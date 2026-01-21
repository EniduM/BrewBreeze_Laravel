<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin
        $admin = Admin::first();

        if (!$admin) {
            $this->command->warn('No admin found. Please run AdminSeeder first.');
            return;
        }

        // Create demo customers
        $customers = [
            [
                'name' => 'John Doe',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'address' => '123 Main St, City, State 12345',
            ],
            [
                'name' => 'Jane Smith',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'address' => '456 Oak Ave, City, State 12346',
            ],
            [
                'name' => 'Bob Johnson',
                'first_name' => 'Bob',
                'last_name' => 'Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'address' => '789 Pine Rd, City, State 12347',
            ],
        ];

        foreach ($customers as $customerData) {
            // Check if customer already exists
            $existingCustomer = Customer::where('email', $customerData['email'])->first();
            $existingUser = User::where('email', $customerData['email'])->first();

            if ($existingCustomer && $existingUser) {
                continue;
            }

            // Create Customer record
            $customer = Customer::firstOrCreate(
                ['email' => $customerData['email']],
                [
                    'admin_id' => $admin->admin_id,
                    'name' => $customerData['name'],
                    'first_name' => $customerData['first_name'],
                    'last_name' => $customerData['last_name'],
                    'password' => $customerData['password'],
                    'phone' => $customerData['phone'],
                    'address' => $customerData['address'],
                ]
            );

            // Create corresponding User record for authentication
            User::firstOrCreate(
                ['email' => $customerData['email']],
                [
                    'name' => $customerData['name'],
                    'password' => $customerData['password'],
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Created ' . count($customers) . ' demo customers');
        $this->command->info('Customer credentials: email / password');
    }
}
