# Laravel Database Seeding

## Creating a Seeder

```bash
php artisan make:seeder CategoryTableSeeder
```

**Output:**
```
INFO  Seeder [database/seeders/CategoryTableSeeder.php] created successfully.
```

## Running Seeders

### Basic Execution
```bash
php artisan db:seed
```

**Output:**
```
INFO  Seeding database.
Database\Seeders\CategoryTableSeeder ....................... RUNNING
Database\Seeders\CategoryTableSeeder ..................... 1 ms DONE
```

### Registering Seeders in DatabaseSeeder

Edit `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        CategoryTableSeeder::class,
    ]);
}
```

Then run:
```bash
php artisan db:seed
```

This executes all registered seeders in the `DatabaseSeeder` class.

## Fresh Migration with Seeding

Combine migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

## Example: ProductTableSeeder

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = DB::table('category')->pluck("id")->toArray();
        
        if(empty($categoryIds)){
            $this->command->warn("NO hay categorias");
            return;
        }

        $products = [];
        for($i = 1; $i <= 50; $i++){
            $products[] = [
                'name' => 'Producto ' . $i,
                'description' => 'Descripcion del producto ' . $i,
                'price' => rand(100, 1000),
                'category_id' => $categoryIds[array_rand($categoryIds)]
            ];
        }

        DB::table('product')->insert($products);
    }
}
```

Run specific seeder:
```bash
php artisan db:seed --class=ProductTableSeeder
```

## Using Faker for Better Seeding

You can enhance seeders using the Faker library for realistic data generation:

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    public function run(): void
    {
        $fake = Faker::create();
        $categoryIds = DB::table('category')->pluck("id")->toArray();
        
        if(empty($categoryIds)){
            $this->command->warn("NO hay categorias");
            return;
        }

        $products = [];
        for($i = 1; $i <= 50; $i++){
            $products[] = [
                'name' => $fake->word,
                'description' => $fake->sentence,
                'price' => $fake->randomFloat(2, 10, 500),
                'category_id' => $fake->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('product')->insert($products);
    }
}
```

### Register in DatabaseSeeder

```php
public function run(): void
{
    $this->call([
        CategoryTableSeeder::class,  // First
        ProductTableSeeder::class    // Then
    ]);
}
```

**Key improvements:** Faker generates realistic names/descriptions, `randomElement()` picks random categories, and timestamps are automatically set.