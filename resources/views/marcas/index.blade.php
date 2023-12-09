@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Marcas</h2>
        <button type="button" class="btn btn-primary align-self-center" id="crear_marca_modal_open">Agregar Marca</button>
    </div>

    <table class="table table-striped table-bordered" id="tabla-marca">
        <thead>
        <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    <!-- Modales -->
    @include('marcas.modals.create')

    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/marcas/init.js') }}"></script>

    
@endsection