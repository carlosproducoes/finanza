<?php

namespace Database\Seeders;

use App\Models\MovementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovementTypeSeeder extends Seeder
{

    public function run(): void
    {
        MovementType::create(['name' => 'entry']);

        MovementType::create(['name' => 'exit']);
    }
}
