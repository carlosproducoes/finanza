<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\FinancialAccountStatus;
use App\Models\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancialAccountFactory extends Factory
{

    public function definition(): array
    {
        return [
            'description' => fake()->words(5, true),
            'due_date' => fake()->date(),
            'payment_date' => $this->getDataOrNull('date'),
            'projected_amount' => fake()->randomFloat(2, 1000, 5000),
            'paid_amount' => $this->getDataOrNull('money'),
            'category_id' => Category::factory(),
            'financial_account_status_id' => FinancialAccountStatus::factory(),
            'movement_type_id' => MovementType::factory(),
            'company_id' => Company::factory(),
        ];
    }

    public function getDataOrNull ($type)
    {
        $isNull = fake()->boolean();

        if ($isNull) {
            return null;
        }

        if ($type == 'date') {
            return fake()->date();
        }

        return fake()->randomFloat(2, 1000, 5000);
    }
}
