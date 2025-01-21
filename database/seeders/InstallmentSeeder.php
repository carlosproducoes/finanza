<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\FinancialAccount;
use App\Models\Installment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstallmentSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                FinancialAccount::inRandomOrder()->where('company_id', '=', $company->id)->where('movement_type', '=', 'exit')->take(3)->get()
                    ->each(function (FinancialAccount $financialAccount) use ($company) {
                        for ($i = 1; $i <= rand(2, 12); $i++) {
                            Installment::factory()
                                ->for($company)
                                ->create([
                                'number' => $i,
                                'financial_account_id' => $financialAccount->id
                            ]);
                        }
                    });
            });
    }
}
