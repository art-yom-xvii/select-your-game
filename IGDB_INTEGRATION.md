# IGDB API Integration Guide

This guide explains how to use the IGDB API integration to populate your "Select Your Game" e-commerce website with video game data.

## Setup

1. First, you need to register for IGDB API access:

    - Go to https://dev.twitch.tv/console/apps
    - Create a new application
    - Get your Client ID and Client Secret

2. Add your credentials to the `.env` file:
    ```
    TWITCH_CLIENT_ID=your_client_id_here
    TWITCH_CLIENT_SECRET=your_client_secret_here
    ```

## Importing Data

There are two ways to import data from IGDB:

### Option 1: Using the Database Seeder

Run the database seeder which will automatically import platforms, genres, and games:

```bash
php artisan db:seed --class=IGDBSeeder
```

### Option 2: Using the Command Directly

You can run the command directly with more control over the import options:

```bash
# Import with default options (50 games)
php artisan igdb:fetch

# Import a specific number of games
php artisan igdb:fetch --limit=100

# Import games for a specific platform
php artisan igdb:fetch --platform=48  # 48 is PlayStation 4

# Import games from a specific genre
php artisan igdb:fetch --genre=5  # 5 is Shooter
```

## Available Platform IDs

Here are some common platform IDs you can use with the `--platform` option:

-   48: PlayStation 4
-   49: Xbox One
-   130: Nintendo Switch
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
    - Platform associations
    - Generated prices based on release date

## Customization

If you need to customize the import process, you can modify the `FetchIGDBData` command in `app/Console/Commands/FetchIGDBData.php`.

Some things you might want to customize:

-   The criteria for selecting games (currently games with rating > 70)
-   The pricing logic based on release date
-   The number of screenshots imported per game
-   The platform and genre filters

## Troubleshooting

If you encounter any issues:

1. Make sure your IGDB API credentials are correct in the `.env` file
2. Check that you have an active internet connection
3. Verify that the IGDB API is available
4. Look for error messages in the command output

If you get rate limit errors, the IGDB API has a limit of 4 requests per second. The integration has built-in error handling, but you may need to wait and try again if you hit rate limits.
