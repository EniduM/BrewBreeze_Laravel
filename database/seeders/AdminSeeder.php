<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = Admin::where('email', 'admin@brewbreeze.com')->first();
        $existingUser = User::where('email', 'admin@brewbreeze.com')->first();

        if ($existingAdmin && $existingUser) {
            $this->command->info('Admin user already exists: admin@brewbreeze.com / password');
            return;
        }

        // Create Admin record
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@brewbreeze.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Create corresponding User record for authentication
        User::firstOrCreate(
            ['email' => 'admin@brewbreeze.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@brewbreeze.com / password');
    }
}
