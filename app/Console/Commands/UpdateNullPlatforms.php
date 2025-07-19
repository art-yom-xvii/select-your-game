<?php

namespace App\Console\Commands;

use App\Models\Platform;
use App\Models\Product;
use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Models\Game;

class UpdateNullPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:update-null-platforms {--limit=50 : Number of products to process per batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products with NULL platform_id by matching to IGDB platforms';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Updating products with NULL platform_id...');

        $limit = $this->option('limit');
        $totalProducts = Product::whereNull('platform_id')->count();

        $this->info("Found {$totalProducts} products with null platform_id");

        if ($totalProducts === 0) {
            $this->info('No products with null platform_id found.');
            return Command::SUCCESS;
        }

        $updated = 0;
        $processed = 0;

        // Process in batches to avoid memory issues
        Product::whereNull('platform_id')->chunk($limit, function ($products) use (&$updated, &$processed, $totalProducts) {
            $bar = $this->output->createProgressBar(count($products));

            foreach ($products as $product) {
                try {
                    // Try to find the IGDB game by name
                    $igdbGame = Game::where('name', $product->name)->with(['platforms'])->first();

                    if ($igdbGame && isset($igdbGame->platforms) && is_array($igdbGame->platforms)) {
                        $this->line("\nFound IGDB game: '{$product->name}' with " . count($igdbGame->platforms) . " platforms");

                        foreach ($igdbGame->platforms as $igdbPlatform) {
                            $this->line("  Checking platform: '{$igdbPlatform->name}'");

                            // Try exact match first (case-insensitive)
                            $localPlatform = Platform::whereRaw('LOWER(name) = ?', [strtolower($igdbPlatform->name)])->first();

                            if (!$localPlatform) {
                                // Try partial match for common variations
                                $searchTerms = [
                                    strtolower($igdbPlatform->name),
                                    str_replace(['(', ')', '-'], '', strtolower($igdbPlatform->name)),
                                    str_replace(['PlayStation', 'PS'], 'PlayStation', strtolower($igdbPlatform->name)),
                                    str_replace(['Xbox', 'XBox'], 'Xbox', strtolower($igdbPlatform->name)),
                                    str_replace(['Nintendo', 'Nintendo Switch'], 'Nintendo Switch', strtolower($igdbPlatform->name)),
                                ];

                                foreach ($searchTerms as $term) {
                                    $localPlatform = Platform::whereRaw('LOWER(name) LIKE ?', ['%' . $term . '%'])->first();
                                    if ($localPlatform) break;
                                }
                            }

                            // If still no match, create the platform
                            if (!$localPlatform) {
                                $localPlatform = Platform::create([
                                    'name' => $igdbPlatform->name,
                                    'slug' => \Illuminate\Support\Str::slug($igdbPlatform->name),
                                    'logo' => null,
                                    'description' => null,
                                    'is_active' => true,
                                ]);

                                $this->line("    Created new platform: '{$igdbPlatform->name}'");
                            } else {
                                $this->line("    Found existing platform: '{$localPlatform->name}'");
                            }

                            if ($localPlatform) {
                                $product->platform_id = $localPlatform->id;
                                $product->save();
                                $updated++;
                                $this->line("    Updated '{$product->name}' with platform '{$localPlatform->name}'");
                                break;
                            }
                        }
                    } else {
                        $this->line("\nNo IGDB game found for: '{$product->name}'");
                    }
                } catch (\Exception $e) {
                    $this->error("\nError updating product {$product->name}: " . $e->getMessage());
                }

                $processed++;
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Processed {$processed}/{$totalProducts} products. Updated: {$updated}");
        });

        $this->info("Final summary: Updated {$updated} out of {$totalProducts} products with platform_id.");
        return Command::SUCCESS;
    }
}
