<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Production;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productions = [
            [
                'name' => 'Produção de Verão',
                'start_date' => Carbon::create(2024, 1, 1),
                'end_date' => Carbon::create(2024, 3, 31),
                'is_active' => true,
            ],
            [
                'name' => 'Produção de Primavera',
                'start_date' => Carbon::create(2024, 4, 1),
                'end_date' => Carbon::create(2024, 6, 30),
                'is_active' => false,
            ],
            [
                'name' => 'Produção de Outono',
                'start_date' => Carbon::create(2024, 7, 1),
                'end_date' => Carbon::create(2024, 9, 30),
                'is_active' => false,
            ],
            [
                'name' => 'Produção de Inverno',
                'start_date' => Carbon::create(2024, 10, 1),
                'end_date' => Carbon::create(2024, 12, 31),
                'is_active' => false,
            ],
        ];

        foreach ($productions as $production) {
            Production::create($production);
        }
    }
}
