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
            'photo' => '/storage/users/Wq8ZmLr7H5bP3kD9sT6vY2xR1jF7nL4mQ8aZ0cX.jpg',
        ]);
    
        User::create([
            'id' => 'NpB6xYd3',
            'name' => 'Issadurofiq',
            'email' => 'rofiq@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => true,
            'photo' => '/storage/users/NpB6xYd3G4tR8mK2jL9pQ7sZ5vX1cF3bH6nM0aD.jpg',
        ]);

        User::create([
            'id' => 'A3fB9cXz',
            'name' => 'Natha Satvika',
            'email' => 'natha@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => false,
            'photo' => '/storage/users/A3fB9cXzR5tY7mP2sK8jL4dQ6vN1bH3gF0aZ7xC.jpg',
        ]);

        User::create([
            'id' => 'kL7pW2Mn',
            'name' => 'Olfat Faiz',
            'email' => 'olfat@gmail.com',
            'encrypted' => Hash::make('12345678'),
            'password' => '12345678',
            'is_admin' => false,
            'photo' => '/storage/users/kL7pW2MnB5sD9fR3tY6vX1jH8mQ4aZ0cF2gN7bP.jpg',
        ]);
    }
}
}
