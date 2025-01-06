<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{

    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                BankAccount::factory(3)
                    ->for($company)
                    ->create();
            });
    }
}
