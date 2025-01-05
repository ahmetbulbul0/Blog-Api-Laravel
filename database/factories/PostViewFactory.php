<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'user_id' => User::factory(),
            'viewed_at' => fake()->dateTimeBetween('-1 month', 'now')
        ];
    }

    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null
        ]);
    }
}
