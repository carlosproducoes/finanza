<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class FinancialAccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(3),
            'due_date' => fake()->date(),
            'payment_date' => fake()->date(),
            'projected_amount' => fake()->randomFloat(2, 100, 4000),
            'paid_amount' => fake()->randomFloat(2, 100, 4000),
            'movement_type' => Arr::random(['entry', 'exit']),
            'status' => Arr::random(['pending', 'paid', 'overdue']),
            'category_id' => Category::factory(),
            'company_id' => Company::factory()
        ];
    }
}
