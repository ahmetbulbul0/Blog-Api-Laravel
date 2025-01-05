<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $mainCategories = [
            [
                'name' => 'Teknoloji',
                'slug' => 'teknoloji',
                'description' => 'Teknoloji ile ilgili yazılar',
            ],
            [
                'name' => 'Yazılım Geliştirme',
                'slug' => 'yazilim-gelistirme',
                'description' => 'Yazılım geliştirme ile ilgili yazılar',
            ],
            [
                'name' => 'Tasarım',
                'slug' => 'tasarim',
                'description' => 'Tasarım ile ilgili yazılar',
            ],
        ];

        foreach ($mainCategories as $category) {
            Category::create($category);
        }

        // Alt kategoriler
        $subCategories = [
            [
                'name' => 'Web Geliştirme',
                'slug' => 'web-gelistirme',
                'description' => 'Web geliştirme ile ilgili yazılar',
                'parent_id' => 2,
            ],
            [
                'name' => 'Mobil Geliştirme',
                'slug' => 'mobil-gelistirme',
                'description' => 'Mobil geliştirme ile ilgili yazılar',
                'parent_id' => 2,
            ],
            [
                'name' => 'UI Tasarım',
                'slug' => 'ui-tasarim',
                'description' => 'UI tasarım ile ilgili yazılar',
                'parent_id' => 3,
            ],
        ];

        foreach ($subCategories as $category) {
            Category::create($category);
        }
    }
}
