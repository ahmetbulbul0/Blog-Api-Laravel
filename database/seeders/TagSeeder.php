<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
            ],
            [
                'name' => 'Vue.js',
                'slug' => 'vuejs',
            ],
            [
                'name' => 'React',
                'slug' => 'react',
            ],
            [
                'name' => 'CSS',
                'slug' => 'css',
            ],
            [
                'name' => 'HTML',
                'slug' => 'html',
            ],
            [
                'name' => 'Git',
                'slug' => 'git',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
