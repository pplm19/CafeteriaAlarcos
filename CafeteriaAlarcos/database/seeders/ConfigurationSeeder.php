<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create([
            'name' => 'maxComensalesTurno',
            'value' => 80,
        ]);

        Configuration::create([
            'name' => 'minDiasReserva',
            'value' => 7,
        ]);

        Configuration::create([
            'name' => 'maxDiasCancelacionReserva',
            'value' => 3,
        ]);
    }
}
