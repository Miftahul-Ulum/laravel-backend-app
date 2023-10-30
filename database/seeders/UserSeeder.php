<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create();
        User::create([
            'name' => 'Miftahul Ulum',
            'email' => 'helloulum@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'phone' => '6289524500594',
            'bio' => 'flutter dev',
            'password' => Hash::make('87654321'),
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'superadmin',
            'phone' => '6281226100656',
            'bio' => 'laravel dev',
            'password' => Hash::make('123456'),
        ]);
    }
}
