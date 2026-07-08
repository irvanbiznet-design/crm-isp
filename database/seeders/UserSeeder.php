<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@crm-isp.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@crm-isp.com',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Finance',
            'email' => 'finance@crm-isp.com',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'finance',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Customer Service',
            'email' => 'cs@crm-isp.com',
            'phone' => '081234567893',
            'password' => Hash::make('password'),
            'role' => 'customer_service',
            'is_active' => true,
        ]);
    }
}
