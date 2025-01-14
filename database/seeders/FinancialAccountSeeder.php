<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FinancialAccount;
use App\Models\Company;
use App\Models\FinancialAccountStatus;
use App\Models\MovementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialAccountSeeder extends Seeder
{

    public function run(): void
    {
        $entryMovementType = MovementType::where('name', 'entry')->first();
        $exitMovementType = MovementType::where('name', 'exit')->first();

        Company::all()
            ->each(function (Company $company) use ($entryMovementType, $exitMovementType) {
                FinancialAccount::factory(10)
                    ->create([
                        'category_id' => Category::inRandomOrder()->first()->id,
                        'financial_account_status_id' => FinancialAccountStatus::inRandomOrder()->first()->id,
                        'movement_type_id' => $entryMovementType->id,
                        'company_id' => $company->id,
                    ]);

                FinancialAccount::factory(10)
                    ->create([
                        'category_id' => Category::inRandomOrder()->first()->id,
                        'financial_account_status_id' => FinancialAccountStatus::inRandomOrder()->first()->id,
                        'movement_type_id' => $exitMovementType->id,
                        'company_id' => $company->id,
                    ]);
            });
    }
}
