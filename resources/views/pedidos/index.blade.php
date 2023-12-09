@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Pedidos</h2>
    </div>

    <div class="form-group" style="margin-top: 20px;">
        <input type="text" id="busqueda" class="form-control " placeholder="Buscar..." style="max-width: 40%;">
    </div>

    <table class="table table-striped table-bordered" id="tabla-producto">
        <thead>
        <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Venta</th>
                <th>Municipio</th>
                <th>Fecha</th>
                <th>Status</th>
                <th>Ver detalles</th>
            </tr>
        </thead>
    </table>

    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/pedidos/init.js') }}"></script>
    
@endsection