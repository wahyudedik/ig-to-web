<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationHelper
{
    /**
     * Send notification to user(s)
     */
    public static function send($users, string $title, string $message, string $type = 'info', array $metadata = [])
    {
        // Convert single user to array
        if ($users instanceof User) {
            $users = [$users];
        }

        foreach ($users as $user) {
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\SystemNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => json_encode([
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'metadata' => $metadata,
                    'created_at' => now(),
                ]),
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Send announcement to all users
     */
    public static function sendAnnouncement(string $title, string $message, string $type = 'info')
    {
        $users = User::all();
        self::send($users, $title, $message, $type, ['type' => 'announcement']);
    }

    /**
     * Send to specific role
     */
    public static function sendToRole(string $role, string $title, string $message, string $type = 'info')
    {
        $users = User::role($role)->get();
        self::send($users, $title, $message, $type, ['role' => $role]);
    }

    /**
     * Welcome notification for new user
     */
    public static function sendWelcome(User $user)
    {
        self::send(
            $user,
            'Selamat Datang di Portal Sekolah! 🎉',
            'Terima kasih telah bergabung dengan sistem kami. Silakan lengkapi profil Anda dan jelajahi fitur-fitur yang tersedia.',
            'success',
            ['type' => 'welcome']
        );
    }

    /**
     * Graduation status notification
     */
    public static function sendGraduationStatus(User $user, string $status, array $details = [])
    {
        $title = $status === 'lulus' ? '🎓 Selamat! Anda Dinyatakan Lulus' : 'Informasi Kelulusan';
        $type = $status === 'lulus' ? 'success' : 'info';

        self::send(
            $user,
            $title,
            "Status kelulusan Anda telah diperbarui. Silakan cek halaman E-Lulus untuk detail lengkap.",
            $type,
            array_merge(['type' => 'graduation', 'status' => $status], $details)
        );
    }

    /**
     * OSIS voting notification
     */
    public static function sendVotingNotification(string $title, string $message, string $type = 'info')
    {
        $users = User::role(['siswa', 'guru'])->get();
        self::send($users, $title, $message, $type, ['type' => 'voting']);
    }

    /**
     * Data change notification
     */
    public static function sendDataChange(User $user, string $what, string $action = 'updated')
    {
        self::send(
            $user,
            'Perubahan Data',
            "Data {$what} Anda telah {$action}. Silakan periksa untuk memastikan informasi sudah benar.",
            'info',
            ['type' => 'data_change', 'what' => $what, 'action' => $action]
        );
    }

    /**
     * Sarpras alert
     */
    public static function sendSarprasAlert(string $title, string $message, string $severity = 'warning')
    {
        $users = User::role(['sarpras', 'admin', 'superadmin'])->get();
        self::send($users, $title, $message, $severity, ['type' => 'sarpras']);
    }

    /**
     * System maintenance notification
     */
    public static function sendMaintenanceAlert(string $startTime, string $endTime)
    {
        self::sendAnnouncement(
            '🔧 Pemeliharaan Sistem Terjadwal',
            "Sistem akan menjalani pemeliharaan dari {$startTime} hingga {$endTime}. Mohon maaf atas ketidaknyamanannya.",
            'warning'
        );
    }

    /**
     * Password changed notification
     */
    public static function sendPasswordChanged(User $user)
    {
        self::send(
            $user,
            '🔒 Password Berhasil Diubah',
            'Password Anda telah berhasil diubah. Jika ini bukan Anda, segera hubungi administrator.',
            'success',
            ['type' => 'security', 'action' => 'password_change']
        );
    }

    /**
     * Approval notification
     */
    public static function sendApproval(User $user, string $what, bool $approved)
    {
        $status = $approved ? 'disetujui' : 'ditolak';
        $type = $approved ? 'success' : 'error';

        self::send(
            $user,
            $approved ? '✅ Permohonan Disetujui' : '❌ Permohonan Ditolak',
            "Permohonan {$what} Anda telah {$status}. Silakan cek untuk detail lebih lanjut.",
            $type,
            ['type' => 'approval', 'what' => $what, 'approved' => $approved]
        );
    }

    /**
     * Reminder notification
     */
    public static function sendReminder(User $user, string $title, string $message)
    {
        self::send(
            $user,
            '⏰ ' . $title,
            $message,
            'warning',
            ['type' => 'reminder']
        );
    }
}
