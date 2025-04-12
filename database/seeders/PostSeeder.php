<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'title' => 'Judul Postingan Pertama',
                'description' => 'Deskripsi lengkap dari postingan pertama.',
                'photo' => 'https://example.com/images/post1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'Vn9jL4cBqTdX7s3M',
                'user_id' => 'kL7pW2Mn',
                'title' => 'Judul Postingan Kedua',
                'description' => 'Deskripsi lengkap dari postingan kedua.',
                'photo' => 'https://example.com/images/post2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
