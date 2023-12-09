@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Categorías</h2>
        <button type="button" class="btn btn-primary align-self-center" id="crear_categoria_modal_open">Agregar Categoría</button>
    </div>

    <div class="form-group" style="margin-top: 20px;">
        <input type="text" id="busqueda" class="form-control " placeholder="Buscar..." style="max-width: 40%;">
    </div>

    <table class="table table-striped table-bordered" id="tabla-categoria">
        <thead>
        <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    <!-- Modales -->
    @include('categorias.modals.create')

    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/categorias/init.js') }}"></script>

    
@endsection