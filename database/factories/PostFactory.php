<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(3, true),
            'excerpt' => fake()->paragraph(),
            'featured_image' => fake()->imageUrl(800, 600),
            'meta_title' => fake()->words(6, true),
            'meta_description' => fake()->sentence(),
            'meta_keywords' => implode(',', fake()->words(5)),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
            'published_at' => fake()->dateTimeBetween('-1 year', '-1 month')
        ]);
    }
}
