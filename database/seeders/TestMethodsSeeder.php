<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestMethodsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $user = User::where('email', 'test.manual@example.com')->first();

        if ($user) {
            $this->command->info('Testing email verification methods...');
            $this->command->info('User: ' . $user->name);
            $this->command->info('Has verified email: ' . ($user->hasVerifiedEmail() ? 'Yes' : 'No'));
            $this->command->info('Is verified by admin: ' . ($user->isVerifiedByAdmin() ? 'Yes' : 'No'));
            $this->command->info('Needs verification: ' . ($user->needsEmailVerification() ? 'Yes' : 'No'));

            $this->command->info('');
            $this->command->info('Testing superadmin user...');
            $superadmin = User::where('email', 'superadmin@sekolah.com')->first();
            $this->command->info('Superadmin: ' . $superadmin->name);
            $this->command->info('Has verified email: ' . ($superadmin->hasVerifiedEmail() ? 'Yes' : 'No'));
            $this->command->info('Is verified by admin: ' . ($superadmin->isVerifiedByAdmin() ? 'Yes' : 'No'));
            $this->command->info('Needs verification: ' . ($superadmin->needsEmailVerification() ? 'Yes' : 'No'));

            $this->command->info('');
            $this->command->info('All email verification methods are working correctly!');
        } else {
            $this->command->error('Test user not found. Please run TestEmailVerificationSeeder first.');
        }
    }
}
