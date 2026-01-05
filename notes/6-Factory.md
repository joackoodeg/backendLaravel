# 📚 **FACTORIES EN LARAVEL** (Fábricas de Datos)

## ¿Qué es una Factory?

Una **Factory** es una herramienta en Laravel que nos permite **generar datos falsos (fake data)** de forma automática. Son súper útiles cuando queremos:

- ✅ Hacer pruebas de nuestra aplicación sin usar datos reales
- ✅ Llenar la base de datos con ejemplos para desarrollo
- ✅ Crear muchos registros rápidamente en los tests
- ✅ Prototipar sin contaminar datos reales de usuarios

---

## 🔧 **CREAR UNA FACTORY**

### Comando para crear:

```bash
php artisan make:factory CategoryFactory
```

**Explicación:**
- `php artisan` → Comando principal de Laravel
- `make:factory` → Indica que vamos a crear una factory
- `CategoryFactory` → Nombre de la factory (siempre singular del modelo)

**Resultado:**
```
INFO  Factory [database/factories/CategoryFactory.php] created successfully.
```

Se crea un archivo en: `database/factories/CategoryFactory.php`

---

## 📝 **ESTRUCTURA DE UNA FACTORY**

### **VERSIÓN 1: Factory Vacía (Por defecto)**

Cuando ejecutas el comando, Laravel crea una factory así:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     * Traduc: Define el estado por defecto del modelo
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Aquí van los campos y valores fake
        ];
    }
}
```

**Explicación línea por línea:**

| Línea | Explicación |
|-------|-------------|
| `namespace Database\Factories;` | Define dónde vive esta clase (ubicación en el proyecto) |
| `use Illuminate\Database\Eloquent\Factories\Factory;` | Importa la clase Factory de Laravel para usar sus funciones |
| `class CategoryFactory extends Factory` | Nuestra clase hereda de Factory (obtiene sus poderes) |
| `public function definition(): array` | Método que DEBE retornar un array con los campos fake |
| `return [...]` | El array con los datos que genera la factory |

---

### **VERSIÓN 2: Factory Configurada (Con datos reales)**

Una vez entiendes cómo funciona, la completas así:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;  // 👈 IMPORTANTE: Importar el modelo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    // Esta propiedad vincula la factory con el modelo Category
    protected $model = Category::class;
    
    /**
     * Define the model's default state.
     * Aquí definimos QUÉ datos queremos generar
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'nombre_del_campo' => valor/generador
            'name' => $this->faker->word(),
        ];
    }
}
```

**Nuevas líneas explicadas:**

| Línea | Explicación |
|-------|-------------|
| `use App\Models\Category;` | Importa el modelo Category para vincular la factory |
| `protected $model = Category::class;` | Dice: "Esta factory es para el modelo Category" |
| `'name' => $this->faker->word(),` | El campo 'name' recibirá una palabra aleatoria |

---

## 🤖 **¿Qué es $this->faker?**

**$this->faker** es un generador de datos fake que Laravel usa (librería Faker). Algunos ejemplos:

```php
$this->faker->word()           // Una palabra random: "dolor", "impedit"
$this->faker->name()           // Un nombre: "Juan García"
$this->faker->email()          // Un email: "juan@example.com"
$this->faker->sentence()       // Una oración: "Ut est et quia dolorem"
$this->faker->numberBetween(1, 100)  // Número entre 1 y 100
$this->faker->unique()->email() // Email único (no se repite)
```

---

## 💡 **CÓMO USAR UNA FACTORY EN CÓDIGO**

Una vez que tu factory está lista, la usas así:

```php
// Crear 1 categoría con datos fake
Category::factory()->create();

// Crear 10 categorías de una vez
Category::factory()->count(10)->create();

// Crear 5 y obtener los objetos (sin guardar aún)
$categories = Category::factory()->count(5)->make();

// Crear con datos personalizados (sobrescribe los defaults)
Category::factory()->create(['name' => 'Electrónica']);

// Crear con múltiples datos personalizados
Category::factory()->create([
    'name' => 'Ropa',
    'description' => 'Ropa y accesorios'
]);
```

---

## 📌 **RESUMEN: Pasos para crear una Factory**

1. **Crear el archivo:** `php artisan make:factory CategoryFactory`
2. **Importar el modelo:** `use App\Models\Category;`
3. **Vincular el modelo:** `protected $model = Category::class;`
4. **Definir campos fake:** En el método `definition()` agregas los campos
5. **Usar en código:** `Category::factory()->create()`

---

## 🎓 **Ejemplo completo: Factory para un Producto**

```php
<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price'       => $this->faker->numberBetween(100, 10000),
            'stock'       => $this->faker->numberBetween(0, 100),
            'active'      => true,
        ];
    }
}
```

Ahora puedes usar: `Product::factory()->count(50)->create()`
