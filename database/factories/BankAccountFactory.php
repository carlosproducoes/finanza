<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->word()) . ' Bank',
            'balance' => fake()->randomFloat(2, 0, 10000),
            'company_id' => Company::factory(),
        ];
    }
}
