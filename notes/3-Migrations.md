# Creating a Migration for Products Table

## Command
```bash
php artisan make:migration create_product_table
```

## Migration File Structure

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
```

## Key Components

- **up()**: Executes when migration runs - creates the table.
- **down()**: Executes when rolling back - drops the table.
- **$table->id()**: Auto-incrementing primary key.
- **$table->timestamps()**: Adds `created_at` and `updated_at` columns.

## Running the Migration
```bash
php artisan migrate
```

## Adding Price to Products Table Migration

### Command
```bash
php artisan make:migration add_price_to_product_table --table=product
```

### Migration File Structure

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal("price", 8, 2); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
```

### Explanation
Esta migración agrega una columna `price` a la tabla `product`. El método `up()` define la adición con tipo decimal (8 dígitos totales, 2 decimales). El método `down()` elimina la columna si se revierte.

### Rollback Command
```bash
php artisan migrate:rollback
```
Revierte la última migración ejecutada.

### Ejemplo de Ejecución
```bash
php artisan migrate:reset
```
Borra todas las migraciones.


