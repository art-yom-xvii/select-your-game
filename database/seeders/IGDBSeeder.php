<?php

namespace Database\Seeders;

use App\Models\Product;
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
        $this->command->info('Running IGDB data import to ensure at least 200 products...');

        // First batch: Get 100 products
        $this->command->info('Importing first batch of products (0-100)...');
        Artisan::call('igdb:fetch', [
            '--limit' => 100,
            '--offset' => 0
        ], $this->command->getOutput());

        // Check how many products we have
        $count = Product::count();
        $this->command->info("Current product count: {$count}");

        // Second batch: Get 100 more products with offset
        $this->command->info('Importing second batch of products (100-200)...');
        Artisan::call('igdb:fetch', [
            '--limit' => 100,
            '--offset' => 100
        ], $this->command->getOutput());

        // Check how many products we have now
        $count = Product::count();
        $this->command->info("Current product count: {$count}");

        // If we still don't have 200 products, get more with a higher offset
        if ($count < 200) {
            $needed = 200 - $count;
            $this->command->info("Still need {$needed} more products. Importing additional batch...");

            Artisan::call('igdb:fetch', [
                '--limit' => $needed + 10, // Add some buffer
                '--offset' => 200
            ], $this->command->getOutput());

            $finalCount = Product::count();
            $this->command->info("Final product count: {$finalCount}");
        }
    }

    /**
     * Add 500 more PS4 games to the database.
     */
    public function addMorePS4Games(): void
    {
        $this->command->info('Adding 500 more PS4 games to the database...');
        $initialCount = Product::count();
        $this->command->info("Initial product count: {$initialCount}");

        // PlayStation 4 platform ID is 48 according to IGDB
        $platformId = 48;
        $batchSize = 100;
        $maxOffset = 5000; // Safety limit to prevent infinite loop
        $currentOffset = 0;
        $targetCount = $initialCount + 500;

        while (Product::count() < $targetCount && $currentOffset < $maxOffset) {
            $this->command->info("Importing PS4 games batch with offset {$currentOffset}...");

            Artisan::call('igdb:fetch', [
                '--limit' => $batchSize,
                '--offset' => $currentOffset,
                '--platform' => $platformId
            ], $this->command->getOutput());

            $currentCount = Product::count();
            $this->command->info("Current product count: {$currentCount}");

            $currentOffset += $batchSize;

            if ($currentCount >= $targetCount) {
                break;
            }
        }

        $finalCount = Product::count();
        $this->command->info("Final product count: {$finalCount}");
        $this->command->info("Added " . ($finalCount - $initialCount) . " new PS4 games.");
    }
}
