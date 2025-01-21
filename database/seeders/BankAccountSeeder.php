<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Company;
use Database\Factories\BankAccountFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                BankAccount::factory(5)
                    ->for($company)
                    ->create();
            });
    }
}
