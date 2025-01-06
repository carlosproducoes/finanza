<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\MovementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $entryMovementType = MovementType::where('name', 'entry')->first();
        $exitMovementType = MovementType::where('name', 'exit')->first();
        
        Company::all()
            ->each(function (Company $company) use ($entryMovementType, $exitMovementType){
                Category::factory(5)
                    ->create([
                        'movement_type_id' => $entryMovementType->id,
                        'company_id' => $company->id,
                    ]);

                Category::factory(5)
                    ->create([
                        'movement_type_id' => $exitMovementType->id,
                        'company_id' => $company->id,
                    ]);
            });
    }
}
