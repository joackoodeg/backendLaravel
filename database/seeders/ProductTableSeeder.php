<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
/**
 * Esta línea importa la fachada DB del espacio de nombres Illuminate\Support\Facades.
 * La fachada DB proporciona una interfaz conveniente para interactuar con la base de datos,
 * permitiendo la ejecución fácil de consultas y operaciones de base de datos.
 */
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();

        $categoryIds= DB::table('category')->pluck("id")->toArray();
        
        if(empty($categoryIds)){
            $this->command->warn("NO hay categorias");
            return;
        }

        $products = [];

        for($i=1; $i<=50; $i++){
            $products[]=[
                'name' => $fake->word, 
                'description' => $fake->sentence,
                'price' => $fake->randomFloat(2, 10, 500),
                /**
                 * Asigna una categoría aleatoria del array $categoryIds a la columna 'category_id'.
                 * 
                 * Utiliza array_rand() para obtener un índice aleatorio del array de IDs de categorías,
                 * y luego accede a ese elemento para asignar el ID de categoría de forma aleatoria
                 * a cada producto durante el seeding de la base de datos.
                 */
                'category_id' => $fake->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now()             
            ];
        }

        DB::table('product')->insert($products);
    }
}
