@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Estudiante</h1>
    <form action="{{ route('estudiantes.store') }}" method="POST">
        @csrf
        <input type="text" name="dni" placeholder="DNI" required maxlength="8">
        <input type="text" name="nombres" placeholder="Nombres" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="text" name="grado_seccion" placeholder="Grado y Sección" required>
        <button type="submit">Guardar</button>
    </form>
</div>
@endsection
