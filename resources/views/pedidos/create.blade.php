@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Termina tu pedido</h2>
    </div>

    <div class="container-fluid" style="margin-top: 20px; display: flex; flex-direction:column; " id="main-content-div">
        <form id="crear_producto_formulario" style="width: 50%;">
            <input type="hidden" name="id" value="">
            
            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" class="form-control" name="nombre">
            </div>

            <div class="form-group">
                <label>Calle</label>
                <input type="text" class="form-control" name="calle">
            </div>

            <div class="form-group">
                <label>Código Postal</label>
                <input type="text" class="form-control" name="cp">
            </div>

            <div class="form-group">
                <label>Número exterior</label>
                <input type="text" class="form-control" name="numero_interior">
            </div>

            <div class="form-group">
                <label>Municipio</label>
                <input type="text" class="form-control" name="municipio">
            </div>

            <div class="form-group">
                <label>Estado</label>
                <input type="text" class="form-control" name="estado">
            </div>

            <div class="form-group">
                <label>Número Telefónico</label>
                <input type="text" class="form-control" name="numero_telefonico">
            </div>

            <button type="button" class="btn btn-primary" id="crear_producto_formulario_mandar">Registra mi pedido</button>

        </form>
    </div>
    
    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/pedidos/initCreate.js') }}"></script>
    
@endsection