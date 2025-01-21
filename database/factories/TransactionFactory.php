<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Company;
use App\Models\FinancialAccount;
use App\Models\Installment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $referenceTypes = [null, 'FinancialAccount', 'Installment'];
        $referenceType = Arr::random($referenceTypes);
        
        $referenceId = null;

        switch ($referenceType) {
            case 'FinancialAccount':
                $referenceId == FinancialAccount::factory();
                break;
            case 'Installment':
                $referenceId = Installment::factory();
                break;
        }

        return [
            'description' => fake()->sentence(3),
            'amount' => fake()->randomFloat(2, 100, 4000),
            'movement_type' => Arr::random(['entry', 'exit']),
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'category_id' => Category::factory(),
            'bank_account_id' => BankAccount::factory(),
            'company_id' => Company::factory()
        ];
    }
}
