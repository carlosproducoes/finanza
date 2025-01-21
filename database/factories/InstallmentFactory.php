<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\FinancialAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class InstallmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => rand(2, 12),
            'due_date' => fake()->date(),
            'payment_date' => fake()->date(),
            'projected_amount' => fake()->randomFloat(2, 100, 4000),
            'paid_amount' => fake()->randomFloat(2, 100, 4000),
            'status' => Arr::random(['pending', 'paid', 'overdue']),
            'financial_account_id' => FinancialAccount::factory(),
            'company_id' => Company::factory()
        ];
    }
}
