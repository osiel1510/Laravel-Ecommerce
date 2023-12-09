@extends('layouts.app')

@section('content')

    <style>

        .width-card {
            display:flex;
            justify-content: flex-end;
        }

        #total-div p{
            font-weight: bold;
            color: #333;
        }

        #total-div {
            display: flex;
            flex-direction: column;
            /* border: 2px solid #ccc; */
            padding: 20px;
            align-items: center;
        }

        #total-div button {
            color: white;
            background: #888888;
            border: none;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px; /* Redondea los bordes del botón */
            transition: background 0.3s; /* Agrega una transición al cambio de color */
        }

        #total-div button:hover {
            background: #00CCCC;
        }    
    </style>
    
    <div class="d-flex justify-content-between">
        <h4 id="title-page">Mi carrito</h4>
    </div>

    <div class="divider">
        <div></div>
    </div>

    <table class="table table-striped table-bordered" id="tabla-carrito">
        <thead>
        <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio total</th>
                <th>Eliminar</th>
            </tr>
        </thead>
    </table>
    
    <div class="width-card">
        <div id="total-div">
            <p id="total">Total: $0</p>
            <button id="button-pagar">Proceder con el pedido</button>
        </div>
    </div>
    
    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/carts/init.js') }}"></script>

@endsection