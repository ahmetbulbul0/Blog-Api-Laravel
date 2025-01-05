<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->paragraph(),
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'status' => 'approved',
            'parent_id' => null
        ];
    }

    public function asGuest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
            'guest_name' => fake()->name(),
            'guest_email' => fake()->safeEmail()
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending'
        ]);
    }

    public function spam(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'spam'
        ]);
    }

    public function asReply(): static
    {
        return $this->state(function (array $attributes) {
            $parentComment = CommentFactory::new()->create();
            return [
                'parent_id' => $parentComment->id,
                'post_id' => $parentComment->post_id
            ];
        });
    }
}
