<?php

namespace Database\Seeders;

use App\Models\FinancialAccountStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialAccountStatusSeeder extends Seeder
{

    public function run(): void
    {
        FinancialAccountStatus::create(['name' => 'pending']);
        FinancialAccountStatus::create(['name' => 'paid']);        
    }
}
