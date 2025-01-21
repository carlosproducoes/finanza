<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Company;
use App\Models\FinancialAccount;
use App\Models\Installment;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                BankAccount::where('company_id', '=', $company->id)
                    ->get()
                    ->each(function (BankAccount $bankAccount) use ($company) {
                        $entryReference = $this->getReferenceOrNull($company, 'entry');
                        $exitReference = $this->getReferenceOrNull($company, 'exit');

                        Transaction::factory(5)
                            ->for($company)
                            ->create([
                                'movement_type' => 'entry',
                                'reference_id' => $entryReference['id'],
                                'reference_type' => $entryReference['type'],
                                'category_id' => Category::where('company_id', '=', $company->id)->where('movement_type', '=', 'entry')->inRandomOrder()->first()->id,
                                'bank_account_id' => $bankAccount->id
                            ]);

                        Transaction::factory(5)
                            ->for($company)
                            ->create([
                                'movement_type' => 'exit',
                                'reference_id' => $exitReference['id'],
                                'reference_type' => $exitReference['type'],
                                'category_id' => Category::where('company_id', '=', $company->id)->where('movement_type', '=', 'exit')->inRandomOrder()->first()->id,
                                'bank_account_id' => $bankAccount->id
                            ]);
                    });
            });
    }

    public function getReferenceOrNull ($company, $movementType)
    {
        $referenceTypes = ['FinancialAccount', 'Installment'];
        $isNull = fake()->boolean();

        if ($isNull) {
            return [
                'id' => null,
                'type' => null
            ];
        }

        $referenceId = null;
        $referenceType = Arr::random($referenceTypes);

        switch ($referenceType) {
            case 'FinancialAccount':
                $referenceId = FinancialAccount::where('company_id', '=', $company->id)->where('movement_type', '=', $movementType)->first()->id;
                break;
            case 'Installment':
                $referenceId = Installment::where('company_id', '=', $company->id)->first()->id;
                break;
        }

        return [
            'id' => $referenceId,
            'type' => $referenceType
        ];
    }
}
