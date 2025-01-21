<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                Category::factory(5)
                    ->for($company)
                    ->create([
                        'parent_id' => $this->getParentOrNull(),
                        'movement_type' => 'entry'
                    ]);

                Category::factory(5)
                    ->for($company)
                    ->create([
                        'parent_id' => $this->getParentOrNull(),
                        'movement_type' => 'exit'
                    ]);
            });
    }

    public function getParentOrNull ()
    {
        $isNull = fake()->boolean();

        if ($isNull) {
            return null;
        }

        $category = Category::inRandomOrder()->first();

        if (empty($category)) {
            return null;
        }

        return $category->id;
    }
}
