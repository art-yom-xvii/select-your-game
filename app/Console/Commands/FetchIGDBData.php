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
    protected $signature = 'igdb:fetch {--limit=50 : Number of games to fetch} {--platform= : Platform ID to filter by} {--genre= : Genre ID to filter by}';

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
        $platformId = $this->option('platform');
        $genreId = $this->option('genre');

        // First, let's fetch and create platforms
        $this->fetchAndCreatePlatforms();

        // Then fetch and create genres as categories
        $this->fetchAndCreateGenres();

        // Finally, fetch games with filters if provided
        $this->fetchAndCreateGames($limit, $platformId, $genreId);

        $this->info('IGDB data import completed successfully!');

        return Command::SUCCESS;
    }

    /**
     * Fetch platforms from IGDB and create them in our database
     */
    private function fetchAndCreatePlatforms(): void
    {
        $this->info('Fetching platforms from IGDB...');

        // Get platforms from IGDB
        $platforms = IGDBPlatform::with(['platform_logo'])
            ->where('category', '=', 1) // Console platforms
            ->orWhere('category', '=', 5) // Portable console
            ->get();

        $this->info('Found ' . count($platforms) . ' platforms');
        $bar = $this->output->createProgressBar(count($platforms));

        foreach ($platforms as $igdbPlatform) {
            // Check if platform already exists
            $platform = Platform::where('name', $igdbPlatform->name)->first();

            if (!$platform) {
                $logoUrl = null;
                if (isset($igdbPlatform->platform_logo)) {
                    $logoUrl = 'https://images.igdb.com/igdb/image/upload/t_thumb/' . $igdbPlatform->platform_logo->image_id . '.jpg';
                }

                Platform::create([
                    'name' => $igdbPlatform->name,
                    'slug' => Str::slug($igdbPlatform->name),
                    'logo' => $logoUrl,
                    'description' => $igdbPlatform->summary ?? null,
                    'is_active' => true,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
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
    private function fetchAndCreateGames(int $limit = 50, ?int $platformId = null, ?int $genreId = null): void
    {
        $this->info('Fetching games from IGDB...');

        // Build query with filters
        $query = Game::with(['cover', 'genres', 'platforms', 'screenshots'])
            ->where('category', '=', 0) // Main game
            ->where('version_parent', '=', null) // Not a version of another game
            ->where('rating', '>', 70) // Only games with good ratings
            ->limit($limit)
            ->orderBy('rating', 'desc');

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

        foreach ($games as $igdbGame) {
            // Skip if no cover or platforms
            if (!isset($igdbGame->cover) || empty($igdbGame->platforms)) {
                $bar->advance();
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

            // Generate SKU
            $sku = 'GAME-' . strtoupper(substr(md5($igdbGame->id . $igdbGame->name), 0, 8));

            // Get platform
            $platformName = isset($igdbGame->platforms[0]->name) ? $igdbGame->platforms[0]->name : null;
            $platform = null;

            if ($platformName) {
                $platform = Platform::where('name', $platformName)->first();
            }

            DB::beginTransaction();

            try {
                // Create product
                $product = Product::create([
                    'name' => $igdbGame->name,
                    'slug' => Str::slug($igdbGame->name . '-' . ($platform ? $platform->name : 'multi')),
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
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('Error importing game: ' . $igdbGame->name . ' - ' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }
}
