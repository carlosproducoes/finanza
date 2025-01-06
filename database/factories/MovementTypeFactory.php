<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovementTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word()
        ];
    }
}
