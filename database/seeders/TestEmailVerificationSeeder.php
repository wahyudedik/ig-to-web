<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestEmailVerificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create a test user that needs email verification (manual registration)
        $testUser = User::create([
            'name' => 'Test User Manual',
            'email' => 'test.manual@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'siswa',
            'email_verified_at' => null, // Not verified
            'is_verified_by_admin' => false, // Not verified by admin
        ]);

        $this->command->info('Test user created:');
        $this->command->info('Name: ' . $testUser->name);
        $this->command->info('Email: ' . $testUser->email);
        $this->command->info('Needs verification: ' . ($testUser->needsEmailVerification() ? 'Yes' : 'No'));
        $this->command->info('Has verified email: ' . ($testUser->hasVerifiedEmail() ? 'Yes' : 'No'));
        $this->command->info('Is verified by admin: ' . ($testUser->isVerifiedByAdmin() ? 'Yes' : 'No'));

        // Test token generation
        $token = $testUser->generateEmailVerificationToken();
        $this->command->info('Generated token: ' . substr($token, 0, 20) . '...');
        $this->command->info('Verification URL: ' . $testUser->getEmailVerificationUrl());

        // Create another test user that is verified by admin
        $adminUser = User::create([
            'name' => 'Test User Admin',
            'email' => 'test.admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'guru',
            'email_verified_at' => now(), // Verified
            'is_verified_by_admin' => true, // Verified by admin
        ]);

        $this->command->info('');
        $this->command->info('Admin-created user:');
        $this->command->info('Name: ' . $adminUser->name);
        $this->command->info('Email: ' . $adminUser->email);
        $this->command->info('Needs verification: ' . ($adminUser->needsEmailVerification() ? 'Yes' : 'No'));
        $this->command->info('Has verified email: ' . ($adminUser->hasVerifiedEmail() ? 'Yes' : 'No'));
        $this->command->info('Is verified by admin: ' . ($adminUser->isVerifiedByAdmin() ? 'Yes' : 'No'));

        $this->command->info('');
        $this->command->info('Email verification system test completed successfully!');
    }
}
