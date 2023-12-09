@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Productos</h2>
        <button type="button" class="btn btn-primary align-self-center" id="crear_producto_modal_open">Agregar Producto</button>
    </div>

    <div class="form-group" style="margin-top: 20px;">
        <input type="text" id="busqueda" class="form-control " placeholder="Buscar..." style="max-width: 40%;">
    </div>


    <table class="table table-striped table-bordered" id="tabla-producto">
        <thead>
        <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Destacado</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    <!-- Modales -->
    @include('productos.modals.create')
    @include('productos.modals.addImages')

    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/productos/init.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/pages/productos/initproductoImagenes.js') }}"></script>
    
@endsection