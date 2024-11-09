<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    // Obtener todos los estudiantes
    public function index()
    {
        $estudiantes = Estudiante::all();
        return response()->json($estudiantes, 200);
    }

    // Crear un nuevo estudiante
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:8|unique:estudiantes,dni',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'grado_seccion' => 'required|string|max:255',
        ]);

        $estudiante = Estudiante::create($request->all());
        return response()->json($estudiante, 201);
    }

    // Obtener un estudiante específico
    public function show($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json($estudiante, 200);
    }

    // Actualizar un estudiante
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $request->validate([
            'dni' => 'sometimes|string|max:8|unique:estudiantes,dni,' . $id . ',id_estudiante',
            'nombres' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'grado_seccion' => 'sometimes|string|max:255',
        ]);

        $estudiante->update($request->all());
        return response()->json($estudiante, 200);
    }

    // Eliminar un estudiante
    public function destroy($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $estudiante->delete();
        return response()->json(['message' => 'Estudiante eliminado correctamente'], 200);
    }
}
