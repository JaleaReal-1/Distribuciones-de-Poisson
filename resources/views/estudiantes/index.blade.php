@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estudiantes</h1>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('estudiantes.index') }}" method="GET" class="d-flex mb-3">
        <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar estudiante">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Botón para agregar nuevo estudiante -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Estudiante</button>

    <!-- Tabla de estudiantes -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Grado y Sección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $estudiante)
                <tr>
                    <td>{{ $estudiante->id_estudiante }}</td>
                    <td>{{ $estudiante->dni }}</td>
                    <td>{{ $estudiante->nombres }}</td>
                    <td>{{ $estudiante->apellidos }}</td>
                    <td>{{ $estudiante->grado_seccion }}</td>
                    <td>
                        <!-- Botón para editar -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar" onclick="editarEstudiante({{ $estudiante }})">Editar</button>
                        <!-- Botón para eliminar -->
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" onclick="eliminarEstudiante({{ $estudiante }})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $estudiantes->links() }}
</div>

<!-- Modal para agregar estudiante -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Agregar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" name="dni" class="form-control" required maxlength="8">
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="grado_seccion">Grado y Sección</label>
                        <input type="text" name="grado_seccion" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar estudiante -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" name="dni" id="dniEditar" class="form-control" required maxlength="8">
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" name="nombres" id="nombresEditar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidosEditar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="grado_seccion">Grado y Sección</label>
                        <input type="text" name="grado_seccion" id="gradoSeccionEditar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para eliminar estudiante -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel">Eliminar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este estudiante?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editarEstudiante(estudiante) {
        document.getElementById('formEditar').action = '/estudiantes/' + estudiante.id_estudiante;
        document.getElementById('dniEditar').value = estudiante.dni;
        document.getElementById('nombresEditar').value = estudiante.nombres;
        document.getElementById('apellidosEditar').value = estudiante.apellidos;
        document.getElementById('gradoSeccionEditar').value = estudiante.grado_seccion;
    }

    function eliminarEstudiante(estudiante) {
        document.getElementById('formEliminar').action = '/estudiantes/' + estudiante.id_estudiante;
    }
</script>
@endsection
