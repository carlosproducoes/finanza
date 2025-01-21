<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\FinancialAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialAccountSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                FinancialAccount::factory(10)
                    ->for($company)
                    ->create([
                        'movement_type' => 'entry',
                        'category_id' => Category::where('movement_type', '=', 'entry')->inRandomOrder()->first()->id
                    ]);

                FinancialAccount::factory(10)
                    ->for($company)
                    ->create([
                        'movement_type' => 'exit',
                        'category_id' => Category::where('movement_type', '=', 'exit')->inRandomOrder()->first()->id
                    ]);
            });
    }
}
