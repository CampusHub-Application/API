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
                'photo' => 'https://campushub-s3.s3.ap-southeast-3.amazonaws.com/posts/MwZ8xpGV1a3qJ9KTtFcXyRn5HgU7vCd4YzP2mNLjEBoAlQ0iXsSr6WbTuhkDeM3f',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'Vn9jL4cBqTdX7s3M',
                'user_id' => 'kL7pW2Mn',
                'title' => 'Foto Bunga Sakura',
                'description' => 'Bunga sakura cantik sekali',
                'photo' => 'https://campushub-s3.s3.ap-southeast-3.amazonaws.com/posts/xA1PYglO03rEQHMcjLTwXBnhvC5tKdR8ipFyZaUSozNsVm7Wk94eG2Jqb6fxdntu',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
