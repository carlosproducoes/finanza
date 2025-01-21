<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'movement_type' => Arr::random(['entry', 'exit']),
            'parent_id' => Category::factory(),
            'company_id' => Company::factory()
        ];
    }
}
