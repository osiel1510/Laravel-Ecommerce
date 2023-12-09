@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Anuncios</h2>
        <button type="button" class="btn btn-primary align-self-center edit-images">Agregar anuncio</button>
    </div>

    <table class="table table-striped table-bordered" id="tabla-imagen">
        <thead>
        <tr>
            <th>Imagen</th>
            <th>Eliminar</th>
        </tr>
        </thead>
    </table>

    <!-- Modales -->
    @include('anuncios.modals.create')

    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/anuncios/init.js') }}"></script>
    
@endsection