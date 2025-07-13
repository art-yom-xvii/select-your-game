<?php

namespace App\Console\Commands;

use App\Models\Platform;
use App\Models\Product;
use Illuminate\Console\Command;

class UpdatePS4Games extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:update-ps4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing games to set them as PS4 games';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting to update games as PS4 games...');

        // First, ensure we have a PlayStation 4 platform
        $platform = Platform::where('name', 'PlayStation 4')->first();

        if (!$platform) {
            $platform = Platform::create([
                'name' => 'PlayStation 4',
                'slug' => 'playstation-4',
                'logo' => 'https://images.igdb.com/igdb/image/upload/t_thumb/pl6f.jpg', // PS4 logo
                'description' => 'Sony PlayStation 4 gaming console',
                'is_active' => true,
            ]);

            $this->info('Created PlayStation 4 platform with ID: ' . $platform->id);
        } else {
            $this->info('Using existing PlayStation 4 platform with ID: ' . $platform->id);
        }

        // Get count of games with null platform_id that were recently added during our PS4 import
        $nullPlatformGames = Product::whereNull('platform_id')
            ->where('id', '>', 210) // Games added after our initial 210 games
            ->count();

        $this->info("Found {$nullPlatformGames} games with null platform_id to update.");

        // Update all games with null platform_id to use the PS4 platform
        $updated = Product::whereNull('platform_id')
            ->where('id', '>', 210) // Games added after our initial 210 games
            ->update(['platform_id' => $platform->id]);

        $this->info("Updated {$updated} games to PlayStation 4 platform.");

        // Verify the update
        $ps4Games = Product::where('platform_id', $platform->id)->count();
        $this->info("Total PlayStation 4 games now: {$ps4Games}");

        return Command::SUCCESS;
    }
}
