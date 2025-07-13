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

### Data Import Options

#### Using the Database Seeder

By default, the seeder imports approximately 200 games:

```bash
php artisan db:seed
```

#### Adding More PS4 Games

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

#### Using the Command Directly

You can run the command with more control:

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

## Common Platform IDs

-   48: PlayStation 4
-   49: Xbox One
-   130: Nintendo Switch
-   167: PlayStation 5
-   169: Xbox Series X|S

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
