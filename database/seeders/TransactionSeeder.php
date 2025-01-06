<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\FinancialAccount;
use App\Models\Company;
use App\Models\MovementType;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{

    public function run(): void
    {
        $entryMovementType = MovementType::where('name', 'entry')->first();
        $exitMovementType = MovementType::where('name', 'exit')->first();

        Company::all()
            ->each(function (Company $company) use ($entryMovementType, $exitMovementType) {
                Transaction::factory(20)
                    ->create([
                        'movement_type_id' => $entryMovementType->id,
                        'bank_account_id' => BankAccount::where('company_id', $company->id)->inRandomOrder()->first(),
                        'company_id' => $company->id,
                        'financial_account_id' => $this->getFinancialAccountOrNull($company->id),
                    ]);

                Transaction::factory(20)
                    ->create([
                        'movement_type_id' => $exitMovementType->id,
                        'bank_account_id' => BankAccount::where('company_id', $company->id)->inRandomOrder()->first(),
                        'company_id' => $company->id,
                        'financial_account_id' => $this->getFinancialAccountOrNull($company->id),
                    ]);
            });
    }

    public function getFinancialAccountOrNull ($companyId)
    {
        $isNull = fake()->boolean();

        if ($isNull) {
            return null;
        }

        FinancialAccount::where('company_id', $companyId)->inRandomOrder()->first();
    }
}
