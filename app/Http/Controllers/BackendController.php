<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class BackendController extends Controller
{
    private $names = [
        1 => ['name' => 'Juan', 'age' => 28],
        2 => ['name' => 'María', 'age' => 34],
        3 => ['name' => 'Luis', 'age' => 45],
    ];
    
    public function getAll(){
        return response()->json($this->names);
    }

    public function get(int $id = 0){
        
        if(isset($this->names[$id])){
        return response()->json([
                    "id" => $id,
                    "succcess" => true,
                    "message" => "El backend funciona correctamente",       
                ]);
        }else{
            return response()->json(["error" => "No existente"], Response::HTTP_NOT_FOUND);
        }       
    }

    public function create(Request $request){
        $person = [
            "id" => count($this->names) + 1,
            "name" => $request->input("name"),
            "age" => $request->input("age")
        ];

        $this->names[$person["id"]] = $person;

        return response()->json(["message" => "Persona creada", "person" => $person], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        if(!isset($this->names[$id])){
            return response()->json(["error" => "No existente"], Response::HTTP_NOT_FOUND);
        }

        $this->names[$id]["name"] = $request->input("name", $this->names[$id]["name"]); // Parametro default
        $this->names[$id]["age"] = $request->input("age");

        return response()->json(["message" => "Persona actualizada", "person" => $this->names[$id]]);
    }

    public function delete(int $id){
        if(!isset($this->names[$id])){
            return response()->json(["error" => "No existente"], Response::HTTP_NOT_FOUND);
        }
        
        unset($this->names[$id]); // Eliminar

        return response()->json(["message" => "Persona eliminada"]);
    }
}
