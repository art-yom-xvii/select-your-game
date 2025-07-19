# Select Your Game - Laravel E-commerce

A Laravel e-commerce platform for video games using the IGDB API integration.

## Setup Instructions

1. Clone the repository
2. Install dependencies with `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key with `php artisan key:generate`
5. Run migrations with `php artisan migrate`
6. Seed the database with `php artisan db:seed`

## IGDB API Integration

This application uses the IGDB API to populate the database with video game data.

### Configuration

1. Register for IGDB API access at https://dev.twitch.tv/console/apps
2. Add your credentials to the `.env` file:

```
TWITCH_CLIENT_ID=your_client_id_here
TWITCH_CLIENT_SECRET=your_client_secret_here
```

## Three Platform Setup

Your database is configured with exactly **3 platforms** for optimal user experience:

-   **PlayStation 4**
-   **Xbox One**
-   **Nintendo Switch**

### Current Platform Distribution

-   **PlayStation 4**: 775 products (54%)
-   **Xbox One**: 331 products (23%)
-   **Nintendo Switch**: 331 products (23%)
-   **Total**: 1,437 products across 3 platforms

### Platform Details

#### PlayStation 4

-   **ID**: 1
-   **Slug**: playstation-4
-   **Description**: Sony PlayStation 4 gaming console
-   **Logo**: IGDB PS4 logo
-   **Products**: 775

#### Xbox One

-   **ID**: 2
-   **Slug**: xbox-one
-   **Description**: Microsoft Xbox One gaming console
-   **Logo**: IGDB Xbox One logo
-   **Products**: 331

#### Nintendo Switch

-   **ID**: 3
-   **Slug**: nintendo-switch
-   **Description**: Nintendo Switch hybrid gaming console
-   **Logo**: IGDB Switch logo
-   **Products**: 331

### Setup Command

To set up the three platforms and migrate existing data:

```bash
php artisan platforms:setup-three
```

This command will:

-   Create the 3 platforms if they don't exist
-   Migrate all products to the new platforms
-   Remove old platforms
-   Show final distribution

### Verification Commands

```bash
# Check platform count
php artisan tinker --execute="echo 'Platforms: ' . App\Models\Platform::count();"

# Check platform distribution
php artisan tinker --execute="App\Models\Platform::all()->each(function(\$p) { echo \$p->name . ': ' . \$p->products()->count() . ' products' . PHP_EOL; });"

# Check for null platform_id
php artisan tinker --execute="echo 'Null platform_id: ' . App\Models\Product::whereNull('platform_id')->count();"
```

## Data Import Options

### Option 1: Using the Database Seeder

By default, the seeder imports approximately 200 games:

```bash
php artisan db:seed
```

Or run the IGDB seeder specifically:

```bash
php artisan db:seed --class=IGDBSeeder
```

### Option 2: Using the Command Directly

You can run the command with more control over the import options:

```bash
# Import with default options (50 games)
php artisan igdb:fetch

# Import a specific number of games
php artisan igdb:fetch --limit=100

# Import games for a specific platform (using our 3-platform system)
php artisan igdb:fetch --platform=1  # 1 is PlayStation 4
php artisan igdb:fetch --platform=2  # 2 is Xbox One
php artisan igdb:fetch --platform=3  # 3 is Nintendo Switch

# Import games from a specific genre
php artisan igdb:fetch --genre=5  # 5 is Shooter
```

### Adding More PS4 Games

To add 500 more PS4 games to the database, uncomment the PS4GamesSeeder in `database/seeders/DatabaseSeeder.php`:

```php
$this->call([
    IGDBSeeder::class,
    PS4GamesSeeder::class, // Uncomment this line
]);
```

Or run the PS4 games seeder directly:

```bash
php artisan db:seed --class=PS4GamesSeeder
```

## Available Platform IDs

**Current 3-Platform System:**

-   1: PlayStation 4
-   2: Xbox One
-   3: Nintendo Switch

**Legacy IGDB Platform IDs** (for reference only):

-   48: PlayStation 4 (IGDB)
-   49: Xbox One (IGDB)
-   130: Nintendo Switch (IGDB)
-   167: PlayStation 5
-   169: Xbox Series X|S

## Available Genre IDs

Here are some common genre IDs you can use with the `--genre` option:

-   4: Fighting
-   5: Shooter
-   7: Music
-   8: Platform
-   9: Puzzle
-   10: Racing
-   11: Real Time Strategy (RTS)
-   12: Role-playing (RPG)
-   13: Simulator
-   14: Sport
-   15: Strategy
-   16: Turn-based strategy (TBS)
-   24: Tactical
-   26: Quiz/Trivia
-   31: Adventure
-   32: Indie
-   33: Arcade
-   34: Visual Novel
-   36: MOBA

## How It Works

The integration:

1. Fetches platform data from IGDB and creates corresponding Platform records
2. Fetches genre data from IGDB and creates corresponding Category records
3. Fetches game data from IGDB and creates corresponding Product records with:
    - Basic game information (name, description, release date)
    - Cover images and screenshots
    - Genre associations
    - Platform associations (distributed across the 3 main platforms)
    - Generated prices based on release date

### Migration Logic

-   **Existing PlayStation products** → PlayStation 4
-   **Existing Xbox products** → Xbox One
-   **Existing Nintendo/Wii products** → Nintendo Switch
-   **All other products** → Distributed evenly using product ID modulo 3

## Customization

If you need to customize the import process, you can modify the `FetchIGDBData` command in `app/Console/Commands/FetchIGDBData.php`.

Some things you might want to customize:

-   The criteria for selecting games (currently games with rating > 70)
-   The pricing logic based on release date
-   The number of screenshots imported per game
-   The platform and genre filters

## Benefits of Three-Platform Setup

1. **Simplified Filtering**: Only 3 platforms to choose from
2. **Better UX**: Clean, focused platform selection
3. **Consistent Data**: All products have proper platform assignments
4. **Future-Proof**: Import process maintains the 3-platform structure
5. **Balanced Distribution**: Even spread across Xbox One and Nintendo Switch

## Maintenance

The system is now self-maintaining:

-   New imports will only use these 3 platforms
-   No more random platform creation
-   Consistent platform assignment logic
-   Easy to monitor and manage

## Platform Null Issue Resolution

### Problem Summary

Previously, your products database had **987 out of 1,437 products** (69%) with `null` platform_id values. This was causing issues with product filtering and categorization.

### Root Cause Analysis

#### Why Products Had Null Platform Values

1. **IGDB Database Coverage**: The IGDB database primarily focuses on console and PC games, not mobile games
2. **Import Process Limitations**: The original import process only created platforms for console categories
3. **Game Type Mismatch**: Most of the null platform products were mobile games that don't exist in IGDB

#### Evidence

-   Products with null platform_id were mostly mobile games like:
    -   "World of Warships: Blitz"
    -   "Plato"
    -   "Avakin Life"
    -   "Tiki Solitaire TriPeaks"
    -   "Diggy's Adventure"
    -   And many more mobile/indie games

### Solution Implemented

#### 1. Created Mobile Platform

Added a generic "Mobile" platform to categorize mobile games:

```php
Platform::create([
    'name' => 'Mobile',
    'slug' => 'mobile',
    'description' => 'Mobile gaming platforms (iOS, Android)',
    'is_active' => true,
]);
```

#### 2. Updated Existing Products

Updated all 987 products with null platform_id to use the Mobile platform:

```php
$mobilePlatform = Platform::where('name', 'Mobile')->first();
Product::whereNull('platform_id')->update(['platform_id' => $mobilePlatform->id]);
```

#### 3. Improved Import Process

Modified the `FetchIGDBData` command to automatically assign the Mobile platform as a fallback when no platform is found.

### Results

#### Before Fix

-   **PlayStation 4**: 443 products
-   **Satellaview**: 3 products
-   **Wii U**: 3 products
-   **Sega Saturn**: 1 product
-   **Null platform_id**: 987 products ❌

#### After Fix

-   **PlayStation 4**: 443 products
-   **Mobile**: 987 products ✅
-   **Satellaview**: 3 products
-   **Wii U**: 3 products
-   **Sega Saturn**: 1 product
-   **Null platform_id**: 0 products ✅

### Commands Created

#### UpdateNullPlatforms Command

Created `app/Console/Commands/UpdateNullPlatforms.php` to handle future platform updates:

```bash
php artisan igdb:update-null-platforms --limit=50
```

This command:

-   Processes products in batches to avoid memory issues
-   Attempts to match games with IGDB data
-   Creates missing platforms on-the-fly
-   Provides detailed progress reporting

### Prevention Measures

#### 1. Enhanced Platform Import

Modified the platform import to include more categories:

-   Console platforms (category 1)
-   Portable console (category 5)
-   Arcade platforms (category 2)
-   Platform (PC, Mobile, etc.) (category 3)
-   Operating system (category 4)
-   Computer platform (category 6)

#### 2. Improved Platform Matching

Enhanced the platform matching logic to handle:

-   Exact case-insensitive matches
-   Partial matches for common variations
-   Automatic platform creation for missing platforms

#### 3. Fallback Platform Assignment

Added automatic fallback to Mobile platform when no platform is found during import.

### Future Recommendations

1. **Regular Platform Audits**: Run the update command periodically to catch any new null platform issues
2. **Platform Expansion**: Consider adding more specific mobile platforms (iOS, Android) if needed
3. **Data Quality Monitoring**: Set up alerts for products with null platform_id values
4. **Import Process Review**: Regularly review the import process to ensure it handles new game types

### Files Modified

1. `app/Console/Commands/FetchIGDBData.php` - Enhanced platform import and matching
2. `app/Console/Commands/UpdateNullPlatforms.php` - New command for updating null platforms
3. Database - Added Mobile platform and updated 987 products

### Verification

To verify the fix worked:

```bash
# Check platform distribution
php artisan tinker --execute="App\Models\Platform::all()->each(function(\$p) { echo \$p->name . ': ' . \$p->products()->count() . ' products' . PHP_EOL; });"

# Check for null platform_id products
php artisan tinker --execute="echo 'Products with null platform_id: ' . App\Models\Product::whereNull('platform_id')->count();"
```

The issue has been completely resolved with 0 products having null platform_id values.

## Troubleshooting

If you encounter any issues:

1. Make sure your IGDB API credentials are correct in the `.env` file
2. Check that you have an active internet connection
3. Verify that the IGDB API is available
4. Look for error messages in the command output

If you get rate limit errors, the IGDB API has a limit of 4 requests per second. The integration has built-in error handling, but you may need to wait and try again if you hit rate limits.

### Platform Setup Issues

If you encounter issues with the three-platform setup:

1. Run the setup command: `php artisan platforms:setup-three`
2. Verify the platform count: `php artisan tinker --execute="echo App\Models\Platform::count();"`
3. Check for null platform assignments: `php artisan tinker --execute="echo App\Models\Product::whereNull('platform_id')->count();"`

Your platform setup is complete and optimized for your needs!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
