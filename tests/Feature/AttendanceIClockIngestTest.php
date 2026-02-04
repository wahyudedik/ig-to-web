<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\AttendanceIdentity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceIClockIngestTest extends TestCase
{
    use RefreshDatabase;

    public function test_iclock_ingest_creates_device_and_logs(): void
    {
        $payload = "1\t2026-02-05 07:00:00\t0\t1\n2\t2026-02-05 07:05:00\t0\t1";

        $response = $this->call('POST', '/iclock/cdata?SN=DEV123', [], [], [], [
            'CONTENT_TYPE' => 'text/plain',
        ], $payload);

        $response->assertOk();

        $this->assertDatabaseHas('attendance_devices', [
            'serial_number' => 'DEV123',
        ]);

        $this->assertDatabaseCount('attendance_logs', 2);

        $this->call('POST', '/iclock/cdata?SN=DEV123', [], [], [], [
            'CONTENT_TYPE' => 'text/plain',
        ], $payload)->assertOk();

        $this->assertDatabaseCount('attendance_logs', 2);
    }

    public function test_attendance_sync_builds_daily_attendance(): void
    {
        $payload = "1\t2026-02-05 07:00:00\t0\t1\n1\t2026-02-05 16:00:00\t0\t1";
        $this->call('POST', '/iclock/cdata?SN=DEV123', [], [], [], [
            'CONTENT_TYPE' => 'text/plain',
        ], $payload)->assertOk();

        $user = User::factory()->create();

        AttendanceIdentity::create([
            'kind' => 'user',
            'user_id' => $user->id,
            'device_pin' => '1',
            'is_active' => true,
        ]);

        $this->artisan('attendance:sync')->assertExitCode(0);

        $this->assertDatabaseCount('attendances', 1);

        $attendance = Attendance::firstOrFail();
        $this->assertSame('2026-02-05', $attendance->date->toDateString());
        $this->assertSame('07:00:00', $attendance->first_in_at->format('H:i:s'));
        $this->assertSame('16:00:00', $attendance->last_out_at->format('H:i:s'));
    }
}
