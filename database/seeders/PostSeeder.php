<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::insert([
            [
                'id' => 'f8Yz3KpWbR6tA1Xc',
                'user_id' => 'A3fB9cXz',
                'title' => 'Foto Pemandangan',
                'description' => 'Wow, pemandangan yang sangat indah',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'Vn9jL4cBqTdX7s3M',
                'user_id' => 'kL7pW2Mn',
                'title' => 'Foto Bunga Sakura',
                'description' => 'Bunga sakura cantik sekali',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
