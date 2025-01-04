<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {

        Company::all()
            ->each(function (Company $company) {
                User::factory()
                    ->for($company)
                    ->create([
                        'role_id' => Role::first()->id,
                    ]);
            });
    }
}
