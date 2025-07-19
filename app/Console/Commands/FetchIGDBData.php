<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Platform;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\Platform as IGDBPlatform;

class FetchIGDBData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:fetch {--limit=50 : Number of games to fetch} {--offset=0 : Offset for pagination} {--platform= : Platform ID to filter by} {--genre= : Genre ID to filter by}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch game data from IGDB API and populate the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting IGDB data import...');

        $limit = $this->option('limit');
        $offset = $this->option('offset');
        $platformId = $this->option('platform');
        $genreId = $this->option('genre');

        // First, let's fetch and create platforms
        $this->fetchAndCreatePlatforms();

        // Then fetch and create genres as categories
        $this->fetchAndCreateGenres();

        // Finally, fetch games with filters if provided
        $this->fetchAndCreateGames($limit, $offset, $platformId, $genreId);

        $this->info('IGDB data import completed successfully!');

        return Command::SUCCESS;
    }

    /**
     * Update products with NULL platform_id by matching to IGDB platforms.
     * Usage: php artisan igdb:update-null-platforms
     */
    public function handleUpdateNullPlatforms(): int
    {
        $this->info('Updating products with NULL platform_id...');
        $products = Product::whereNull('platform_id')->get();
        $updated = 0;

        $bar = $this->output->createProgressBar(count($products));

        foreach ($products as $product) {
            try {
                // Try to find the IGDB game by name
                $igdbGame = Game::where('name', $product->name)->with('platforms')->first();

                if ($igdbGame && isset($igdbGame->platforms) && is_array($igdbGame->platforms)) {
                    foreach ($igdbGame->platforms as $igdbPlatform) {
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

                        if ($localPlatform) {
                            $product->platform_id = $localPlatform->id;
                            $product->save();
                            $updated++;
                            $this->line("\nUpdated '{$product->name}' with platform '{$localPlatform->name}'");
                            break;
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("\nError updating product {$product->name}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Updated {$updated} products with platform_id.");
        return Command::SUCCESS;
    }

    /**
     * Fetch platforms from IGDB and create them in our database
     */
    private function fetchAndCreatePlatforms(): void
    {
        $this->info('Setting up 3 main platforms...');

        // Only create the 3 main platforms we want
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
            // Check if platform already exists
            $platform = Platform::where('name', $platformData['name'])->first();

            if (!$platform) {
                Platform::create([
                    'name' => $platformData['name'],
                    'slug' => $platformData['slug'],
                    'logo' => $platformData['logo'],
                    'description' => $platformData['description'],
                    'is_active' => true,
                ]);

                $this->line("Created platform: {$platformData['name']}");
            } else {
                $this->line("Platform already exists: {$platformData['name']}");
            }
        }

        $this->info('Platform setup completed.');
    }

    /**
     * Fetch genres from IGDB and create them as categories in our database
     */
    private function fetchAndCreateGenres(): void
    {
        $this->info('Fetching genres from IGDB...');

        // Get genres from IGDB
        $genres = Genre::all();

        $this->info('Found ' . count($genres) . ' genres');
        $bar = $this->output->createProgressBar(count($genres));

        foreach ($genres as $igdbGenre) {
            // Check if category already exists
            $category = Category::where('name', $igdbGenre->name)->first();

            if (!$category) {
                Category::create([
                    'name' => $igdbGenre->name,
                    'slug' => Str::slug($igdbGenre->name),
                    'description' => null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    /**
     * Fetch games from IGDB and create them as products in our database
     */
    private function fetchAndCreateGames(int $limit = 50, int $offset = 0, ?int $platformId = null, ?int $genreId = null): void
    {
        $this->info('Fetching games from IGDB...');

        // Build query with filters
        $query = Game::with(['cover', 'genres', 'platforms', 'screenshots'])
            ->where('category', '=', 0) // Main game
            ->where('version_parent', '=', null) // Not a version of another game
            ->offset($offset)
            ->limit($limit)
            ->orderBy('rating', 'desc');

        // Set rating threshold based on platform filter
        // For PS4 games (ID 48), use a lower threshold to get more games
        if ($platformId && $platformId == 48) {
            $query->where('rating', '>', 50); // Lower threshold for PS4 games
        } else {
            $query->where('rating', '>', 70); // Original threshold for other games
        }

        // Add platform filter if provided
        if ($platformId) {
            $query->where('platforms', '=', [$platformId]);
        }

        // Add genre filter if provided
        if ($genreId) {
            $query->where('genres', '=', [$genreId]);
        }

        // Get games
        $games = $query->get();

        $this->info('Found ' . count($games) . ' games');
        $bar = $this->output->createProgressBar(count($games));

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($games as $igdbGame) {
            // Skip if no cover or platforms
            if (!isset($igdbGame->cover) || empty($igdbGame->platforms)) {
                $bar->advance();
                $skippedCount++;
                continue;
            }

            // Generate a price based on release date (newer games cost more)
            $price = 19.99;
            if (isset($igdbGame->first_release_date)) {
                $releaseYear = $igdbGame->first_release_date->format('Y');
                $currentYear = date('Y');
                $yearDiff = $currentYear - $releaseYear;

                if ($yearDiff <= 1) {
                    $price = 59.99;
                } elseif ($yearDiff <= 3) {
                    $price = 39.99;
                } elseif ($yearDiff <= 5) {
                    $price = 29.99;
                }
            }

            // Check if product with this name already exists
            $existingProduct = Product::where('name', $igdbGame->name)->first();
            if ($existingProduct) {
                $this->line("\nSkipping existing product: " . $igdbGame->name);
                $bar->advance();
                $skippedCount++;
                continue;
            }

            // Generate unique SKU
            $attempts = 0;
            do {
                if ($attempts > 0) {
                    // Add random suffix on retry
                    $randomSuffix = rand(1000, 9999);
                    $sku = 'GAME-' . strtoupper(substr(md5($igdbGame->id . $igdbGame->name . $randomSuffix), 0, 8));
                } else {
                    $sku = 'GAME-' . strtoupper(substr(md5($igdbGame->id . $igdbGame->name), 0, 8));
                }
                $skuExists = Product::where('sku', $sku)->exists();
                $attempts++;
            } while ($skuExists && $attempts < 5);

            if ($skuExists) {
                $this->error("Could not generate unique SKU for: " . $igdbGame->name);
                $bar->advance();
                $skippedCount++;
                continue;
            }

            // Improved platform matching: check all IGDB platforms for a match
            $platform = null;
            if (isset($igdbGame->platforms) && is_array($igdbGame->platforms)) {
                foreach ($igdbGame->platforms as $igdbPlatform) {
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

                    if ($localPlatform) {
                        $platform = $localPlatform;
                        break;
                    }
                }
            }

            // For PlayStation 4 games, explicitly set the platform
            if ($platformId && $platformId == 48 && !$platform) {
                $platform = Platform::where('name', 'PlayStation 4')->first();

                // If PlayStation 4 platform doesn't exist yet, create it
                if (!$platform) {
                    $platform = Platform::create([
                        'name' => 'PlayStation 4',
                        'slug' => 'playstation-4',
                        'logo' => 'https://images.igdb.com/igdb/image/upload/t_thumb/pl6f.jpg', // PS4 logo
                        'description' => 'Sony PlayStation 4 gaming console',
                        'is_active' => true,
                    ]);

                    $this->info('Created PlayStation 4 platform: ' . $platform->id);
                }
            }

                        // Fallback to one of the 3 main platforms if no platform is found
            if (!$platform) {
                // Get the 3 main platforms
                $ps4 = Platform::where('name', 'PlayStation 4')->first();
                $xboxOne = Platform::where('name', 'Xbox One')->first();
                $nintendoSwitch = Platform::where('name', 'Nintendo Switch')->first();

                // Distribute evenly based on game ID
                $platformChoice = $igdbGame->id % 3;

                switch ($platformChoice) {
                    case 0:
                        $platform = $ps4;
                        break;
                    case 1:
                        $platform = $xboxOne;
                        break;
                    case 2:
                        $platform = $nintendoSwitch;
                        break;
                    default:
                        $platform = $ps4; // Default fallback
                }

                if ($platform) {
                    $this->info('Assigned to ' . $platform->name . ' platform');
                }
            }

            DB::beginTransaction();

            try {
                // Create product
                $product = Product::create([
                    'name' => $igdbGame->name,
                    'slug' => Str::slug($igdbGame->name . '-' . ($platform ? $platform->slug : 'multi')),
                    'description' => $igdbGame->summary ?? null,
                    'short_description' => Str::limit($igdbGame->summary ?? '', 150),
                    'price' => $price,
                    'compare_at_price' => $price + 10,
                    'sku' => $sku,
                    'stock' => rand(5, 50),
                    'is_digital' => false,
                    'is_featured' => $igdbGame->rating > 85,
                    'is_active' => true,
                    'platform_id' => $platform ? $platform->id : null,
                    'publisher' => isset($igdbGame->involved_companies) ? 'Unknown Publisher' : null,
                    'developer' => isset($igdbGame->involved_companies) ? 'Unknown Developer' : null,
                    'release_date' => isset($igdbGame->first_release_date) ? $igdbGame->first_release_date->format('Y-m-d') : null,
                    'product_type' => 'game',
                    'esrb_rating' => null,
                ]);

                // Add cover image
                if (isset($igdbGame->cover)) {
                    $coverUrl = 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdbGame->cover->image_id . '.jpg';

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $coverUrl,
                        'alt_text' => $igdbGame->name . ' Cover',
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]);
                }

                // Add screenshots as additional images
                if (isset($igdbGame->screenshots)) {
                    $sortOrder = 1;
                    foreach ($igdbGame->screenshots as $screenshot) {
                        if ($sortOrder > 5) break; // Limit to 5 screenshots

                        $screenshotUrl = 'https://images.igdb.com/igdb/image/upload/t_screenshot_big/' . $screenshot->image_id . '.jpg';

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $screenshotUrl,
                            'alt_text' => $igdbGame->name . ' Screenshot ' . $sortOrder,
                            'is_primary' => false,
                            'sort_order' => $sortOrder,
                        ]);

                        $sortOrder++;
                    }
                }

                // Add genres as categories
                if (isset($igdbGame->genres)) {
                    foreach ($igdbGame->genres as $genre) {
                        $category = Category::where('name', $genre->name)->first();

                        if ($category) {
                            $product->categories()->attach($category->id);
                        }
                    }
                }

                DB::commit();
                $importedCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('Error importing game: ' . $igdbGame->name . ' - ' . $e->getMessage());
                $skippedCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Import summary: {$importedCount} games imported, {$skippedCount} games skipped.");
    }
}
