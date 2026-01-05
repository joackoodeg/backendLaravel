# Documentación - BackendController

## Descripción General
Controlador Laravel que implementa un CRUD (Create, Read, Update, Delete) para gestionar una lista de personas. Los datos se almacenan en memoria (array privado).

## Aprendizajes Clave

### 1. **Estructura del Controlador**
- Los controladores se crean con `php artisan make:controller NombreController`
- Se ubican en `app/Http/Controllers/`
- Heredan de la clase `Controller`

### 2. **Métodos CRUD Implementados**

| Método | Acción | HTTP |
|--------|--------|------|
| `getAll()` | Obtiene todas las personas | GET |
| `get(int $id)` | Obtiene una persona por ID | GET |
| `create(Request $request)` | Crea una nueva persona | POST |
| `update(Request $request, $id)` | Actualiza una persona | PUT |
| `delete(int $id)` | Elimina una persona | DELETE |

### 3. **Conceptos Importantes**

- **response()->json()**: Retorna respuestas en formato JSON
- **Response::HTTP_*****: Constantes para códigos HTTP (NOT_FOUND, CREATED, etc.)
- **Request::input()**: Obtiene datos del request con parámetros por defecto
- **isset()**: Verifica si una clave existe en el array
- **unset()**: Elimina un elemento del array

### 4. **Rutas Configuradas**

# Crear

kln% php artisan make:controller BackendController

   INFO  Controller [app/Http/Controllers/BackendController.php] created successfully.  

kln% 

Se crean en app/http/controllers


### Controlador: BackendController

**Descripción General:**
Controlador que gestiona operaciones CRUD (Create, Read, Update, Delete) para una colección de personas. Utiliza un array privado como almacenamiento temporal de datos.

**Propiedades:**
- `$names`: Array asociativo que almacena objetos persona con estructura id => ['name' => string, 'age' => int]

**Métodos:**

- **getAll()**: Retorna todas las personas en formato JSON
- **get(int $id)**: Retorna una persona específica por ID. Valida existencia del ID antes de responder
- **create(Request $request)**: Crea una nueva persona con name y age del request. Asigna ID automático y retorna HTTP 201
- **update(Request $request, $id)**: Actualiza datos de una persona existente. El nombre tiene valor por defecto si no se proporciona
- **delete(int $id)**: Elimina una persona del array por ID. Valida existencia antes de eliminar

### Rutas API

**GET /test**: 
Ruta de prueba que retorna mensaje de confirmación

**GET /backend**: 
Obtiene todas las personas registradas

**GET /backend/{id?}**: 
Obtiene una persona específica por ID (parámetro opcional)

**POST /backend**: 
Crea una nueva persona con datos del body request

**PUT /backend/{id}**: 
Actualiza datos de una persona existente por ID

**DELETE /backend/{id}**: 
Elimina una persona por ID