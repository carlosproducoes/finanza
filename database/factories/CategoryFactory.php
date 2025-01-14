<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'movement_type_id' => MovementType::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
