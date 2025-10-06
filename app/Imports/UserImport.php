<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class UserImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    protected $rowCount = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Check if user already exists by email
        $existing = User::where('email', $row['email'])->first();

        if ($existing) {
            Log::info("Skipping duplicate email: {$row['email']} for {$row['name']}");
            return null;
        }

        $this->rowCount++;

        return new User([
            'name' => trim($row['name']),
            'email' => trim($row['email']),
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password
            'user_type' => trim($row['user_type']),
            'email_verified_at' => !empty($row['email_verified_at']) ? \Carbon\Carbon::parse($row['email_verified_at']) : null,
            'is_verified_by_admin' => isset($row['is_verified_by_admin']) ?
                (strtolower($row['is_verified_by_admin']) === 'yes' || $row['is_verified_by_admin'] === '1') : false,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.email' => 'required|email|max:255',
            '*.user_type' => 'required|in:superadmin,admin,guru,siswa,sarpras',
            '*.password' => 'nullable|string|min:6',
            '*.email_verified_at' => 'nullable|date',
            '*.is_verified_by_admin' => 'nullable|in:yes,no,1,0',
        ];
    }

    /**
     * Get the number of rows imported
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
