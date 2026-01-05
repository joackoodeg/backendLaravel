# Models y Factories en Laravel

## Models
Los **Models** representan las tablas de tu base de datos. Heredan de `Eloquent` y permiten:
- Definir relaciones entre tablas
- Validar datos
- Realizar consultas de forma elegante

```php
class Post extends Model
{
    protected $fillable = ['title', 'content'];
}
```

## Factories
Las **Factories** generan datos de prueba de forma masiva. Útiles para testing y seeding:

```php
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
```

Uso:
```php
Post::factory()->count(10)->create();
```
## Creación de Models

Para crear un model, usa el comando artisan:

```php
php artisan make:model Category
```

Esto genera un archivo en `app/Models/Category.php`:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
}
```

### Especificar el nombre de la tabla

Por defecto, Laravel busca una tabla con el nombre en plural y minúsculas. Si tu tabla tiene otro nombre, especifícalo con la propiedad `$table`:

```php
class Category extends Model
{
    protected $table = 'category';
}
```

También puedes usar `$fillable` para definir qué campos pueden ser asignados masivamente:

```php
class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name', 'description'];
}
```
## Relaciones entre Models

### belongsTo (Pertenece a)
Usada cuando un modelo pertenece a otro. Por ejemplo, un Post pertenece a una Category:

```php
class Post extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

Uso:
```php
$post = Post::find(1);
echo $post->category->name; // Accede al nombre de la categoría
```

### hasMany (Tiene muchos)
Usada en el modelo inverso. Una Category tiene muchos Posts:

```php
class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

Uso:
```php
$category = Category::find(1);
foreach ($category->posts as $post) {
    echo $post->title;
}
```

### hasOne (Tiene uno)
Similar a hasMany, pero retorna un único registro:

```php
public function profile()
{
    return $this->hasOne(Profile::class);
}
```

### manyToMany (Muchos a muchos)
Usada cuando dos modelos se relacionan mutuamente. Por ejemplo, un Product puede tener muchas Categories y una Category puede tener muchos Products:

```php
class Product extends Model
{
    protected $fillable = ['name', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
```

```php
class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
```

Uso:
```php
$product = Product::find(1);
foreach ($product->categories as $category) {
    echo $category->name;
}
```

**Nota:** Para relaciones muchos a muchos, necesitas una tabla pivot que conecte ambos modelos. Por ejemplo: `category_product`.