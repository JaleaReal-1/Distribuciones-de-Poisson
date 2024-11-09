<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $estudiantes = Estudiante::where('nombres', 'like', '%' . $buscar . '%')
                                  ->orWhere('apellidos', 'like', '%' . $buscar . '%')
                                  ->paginate(10);
        return view('estudiantes.index', compact('estudiantes', 'buscar'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|max:8',
            'nombres' => 'required',
            'apellidos' => 'required',
            'grado_seccion' => 'required',
        ]);

        Estudiante::create($request->all());
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado con éxito.');
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dni' => 'required|max:8',
            'nombres' => 'required',
            'apellidos' => 'required',
            'grado_seccion' => 'required',
        ]);

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->update($request->all());
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado con éxito.');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado con éxito.');
    }
}
