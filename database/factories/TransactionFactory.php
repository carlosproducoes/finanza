<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\FinancialAccount;
use App\Models\Company;
use App\Models\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'description' => fake()->words(3, true),
            'date' => fake()->date(),
            'amount' => fake()->randomFloat(2, 50, 1000),
            'current_balance' => fake()->randomFloat(2, 4000, 10000),
            'movement_type_id' => MovementType::factory(),
            'bank_account_id' => BankAccount::factory(),
            'company_id' => Company::factory(),
            'financial_account_id' => FinancialAccount::factory() || null,
        ];
    }
}
