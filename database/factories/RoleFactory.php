<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([Role::ADMIN, Role::AUTHOR, Role::VISITOR]),
            'description' => fake()->sentence()
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => Role::ADMIN,
            'description' => 'Administrator role with full access'
        ]);
    }

    public function author(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => Role::AUTHOR,
            'description' => 'Author role with content management access'
        ]);
    }

    public function visitor(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => Role::VISITOR,
            'description' => 'Visitor role with basic access'
        ]);
    }
}
