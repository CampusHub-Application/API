<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Hasbi Mizan',
            'email' => 'hasbi@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
    
        User::create([
            'name' => 'Issadurofiq',
            'email' => 'rofiq@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Natha Satvika',
            'email' => 'natha@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Olfat Faiz',
            'email' => 'olfat@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);
    }
}
