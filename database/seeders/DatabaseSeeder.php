<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
        ]);

        $this->command->info('Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('Demo Credentials:');
        $this->command->info('Admin: admin@brewbreeze.com / password');
        $this->command->info('Customer: john@example.com / password');
        $this->command->info('Customer: jane@example.com / password');
        $this->command->info('Customer: bob@example.com / password');
    }
}
