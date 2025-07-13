<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PS4GamesSeeder extends Seeder
{
    /**
     * Run the database seeds to add 500 more PS4 games.
     */
    public function run(): void
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
            $this->command->info("Added " . ($currentCount - $initialCount) . " games so far. Need " . ($targetCount - $currentCount) . " more.");

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
