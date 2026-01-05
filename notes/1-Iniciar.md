# Ejecutar Servidor Local
```bash
php -S localhost:8000 -t public
```

# Configurar API en Laravel

Edita el archivo `bootstrap/app.php` y añade la ruta de la API:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/php', // Aca se agrega API
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
