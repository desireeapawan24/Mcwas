<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'email'      => 'admin@macwas.com',
            'password'   => Hash::make('Entity123!'),
            'role'       => 'admin',
            'status'     => 'active',
        ]);
    }
}
    