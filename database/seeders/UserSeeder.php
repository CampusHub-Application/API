<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'id' => 'Wq8ZmLr7',
            'name' => 'Hasbi Mizan',
            'email' => 'hasbi@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => true,
        ]);
    
        User::create([
            'id' => 'NpB6xYd3',
            'name' => 'Issadurofiq',
            'email' => 'rofiq@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => true,
        ]);

        User::create([
            'id' => 'A3fB9cXz',
            'name' => 'Natha Satvika',
            'email' => 'natha@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => false,
        ]);

        User::create([
            'id' => 'kL7pW2Mn',
            'name' => 'Olfat Faiz',
            'email' => 'olfat@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => false,
        ]);
    }
}
