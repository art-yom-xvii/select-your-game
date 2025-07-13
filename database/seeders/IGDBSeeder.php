<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class IGDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run the IGDB fetch command with default options
        $this->command->info('Running IGDB data import...');
        Artisan::call('igdb:fetch', [], $this->command->getOutput());
    }
}
