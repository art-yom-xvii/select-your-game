<?php

namespace App\Console\Commands;

use App\Models\Platform;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetupThreePlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platforms:setup-three';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up exactly 3 platforms: PlayStation 4, Xbox One, and Nintendo Switch';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Setting up 3 platforms: PlayStation 4, Xbox One, and Nintendo Switch...');

        // Step 1: Create the 3 platforms
        $this->createPlatforms();

        // Step 2: Migrate existing products
        $this->migrateProducts();

        // Step 3: Remove old platforms
        $this->removeOldPlatforms();

        $this->info('Platform setup completed successfully!');
        return Command::SUCCESS;
    }

    /**
     * Create the 3 platforms
     */
    private function createPlatforms(): void
    {
        $this->info('Creating platforms...');

        $platforms = [
            [
                'name' => 'PlayStation 4',
                'slug' => 'playstation-4',
                'description' => 'Sony PlayStation 4 gaming console',
                'logo' => 'https://images.igdb.com/igdb/image/upload/t_thumb/pl6f.jpg'
            ],
            [
                'name' => 'Xbox One',
                'slug' => 'xbox-one',
                'description' => 'Microsoft Xbox One gaming console',
                'logo' => 'https://images.igdb.com/igdb/image/upload/t_thumb/pl6e.jpg'
            ],
            [
                'name' => 'Nintendo Switch',
                'slug' => 'nintendo-switch',
                'description' => 'Nintendo Switch hybrid gaming console',
                'logo' => 'https://images.igdb.com/igdb/image/upload/t_thumb/pl6f.jpg'
            ]
        ];

        foreach ($platforms as $platformData) {
            $platform = Platform::where('name', $platformData['name'])->first();

            if (!$platform) {
                $platform = Platform::create([
                    'name' => $platformData['name'],
                    'slug' => $platformData['slug'],
                    'description' => $platformData['description'],
                    'logo' => $platformData['logo'],
                    'is_active' => true,
                ]);
                $this->line("Created platform: {$platform->name}");
            } else {
                $this->line("Platform already exists: {$platform->name}");
            }
        }
    }

    /**
     * Migrate existing products to the new platforms
     */
    private function migrateProducts(): void
    {
        $this->info('Migrating products to new platforms...');

        // Get the 3 platforms
        $ps4 = Platform::where('name', 'PlayStation 4')->first();
        $xboxOne = Platform::where('name', 'Xbox One')->first();
        $nintendoSwitch = Platform::where('name', 'Nintendo Switch')->first();

        if (!$ps4 || !$xboxOne || !$nintendoSwitch) {
            $this->error('One or more required platforms not found!');
            return;
        }

        // Get all products
        $products = Product::all();
        $migrated = 0;

        $bar = $this->output->createProgressBar(count($products));

        foreach ($products as $product) {
            $oldPlatformId = $product->platform_id;

            // Determine new platform based on current platform or product characteristics
            $newPlatformId = $this->determineNewPlatform($product, $ps4, $xboxOne, $nintendoSwitch);

            if ($newPlatformId && $newPlatformId !== $oldPlatformId) {
                $product->platform_id = $newPlatformId;
                $product->save();
                $migrated++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Migrated {$migrated} products to new platforms.");
    }

    /**
     * Determine which platform a product should be assigned to
     */
    private function determineNewPlatform($product, $ps4, $xboxOne, $nintendoSwitch): ?int
    {
        // If product already has a platform, try to map it
        if ($product->platform_id) {
            $currentPlatform = Platform::find($product->platform_id);

            if ($currentPlatform) {
                $platformName = strtolower($currentPlatform->name);

                // Map existing platforms to new ones
                if (str_contains($platformName, 'playstation') || str_contains($platformName, 'ps4')) {
                    return $ps4->id;
                }
                if (str_contains($platformName, 'xbox') || str_contains($platformName, 'xbox one')) {
                    return $xboxOne->id;
                }
                if (str_contains($platformName, 'nintendo') || str_contains($platformName, 'switch') || str_contains($platformName, 'wii')) {
                    return $nintendoSwitch->id;
                }
            }
        }

        // For products without platforms or unmapped platforms, distribute evenly
        // Use product ID to ensure consistent distribution
        $platformChoice = $product->id % 3;

        switch ($platformChoice) {
            case 0:
                return $ps4->id;
            case 1:
                return $xboxOne->id;
            case 2:
                return $nintendoSwitch->id;
            default:
                return $ps4->id; // Default fallback
        }
    }

    /**
     * Remove old platforms
     */
    private function removeOldPlatforms(): void
    {
        $this->info('Removing old platforms...');

        // Get the 3 platforms we want to keep
        $keepPlatforms = Platform::whereIn('name', ['PlayStation 4', 'Xbox One', 'Nintendo Switch'])->pluck('id');

        // Remove all other platforms
        $removed = Platform::whereNotIn('id', $keepPlatforms)->delete();

        $this->info("Removed {$removed} old platforms.");

        // Show final platform count
        $finalCount = Platform::count();
        $this->info("Final platform count: {$finalCount}");

        // Show platform distribution
        $this->info('Final platform distribution:');
        Platform::all()->each(function ($platform) {
            $count = $platform->products()->count();
            $this->line("  {$platform->name}: {$count} products");
        });
    }
}
