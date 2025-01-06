<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            MovementTypeSeeder::class,
            BankAccountSeeder::class,
            CategorySeeder::class,
            FinancialAccountStatusSeeder::class,
            FinancialAccountSeeder::class,
            TransactionSeeder::class,
        ]);

        User::factory()
            ->create([
                'name' => 'Carlos Gonçalves',
                'email' => 'carlos.goncalves@gmail.com',
                'role_id' => Role::first(),
                'company_id' => Company::first(),
            ]);
    }
}
