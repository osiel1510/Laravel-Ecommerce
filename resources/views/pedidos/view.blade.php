@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between">
    <h2 id="title-page">Pedido #{{$pedido->id}}</h2>
</div>

<div style="display: flex; width: 100%;">
    <!-- Sección de Información de Pedido -->
    <div class="row mt-4" style="width: 100%;">
        <div class="col-md-6">
            <h3>Información de Pedido</h3>
            <ul>
                <li><strong>Nombre:</strong> {{$pedido->nombre}}</li>
                <li><strong>Correo:</strong> {{$pedido->correo}}</li>
                <li><strong>Calle:</strong> {{$pedido->calle}}</li>
                <li><strong>CP:</strong> {{$pedido->cp}}</li>
                <li><strong>Número Interior:</strong> {{$pedido->numero_interior}}</li>
                <li><strong>Municipio:</strong> {{$pedido->municipio}}</li>
                <li><strong>Estado:</strong> {{$pedido->estado}}</li>
                <li><strong>Número Telefónico:</strong> {{$pedido->numero_telefonico}}</li>
                <li><strong>Estado:</strong> 
                    @if ($pedido->status === 'pendiente')
                        <span class="text-warning" style="font-weight: bold;">{{ $pedido->status }}</span>
                    @elseif ($pedido->status === 'completado')
                        <span class="text-success"  style="font-weight: bold;">{{ $pedido->status }}</span>
                    @elseif ($pedido->status === 'cancelado')
                        <span class="text-danger"  style="font-weight: bold;">{{ $pedido->status }}</span>
                    @else
                        {{ $pedido->status }}
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <!-- Botones para cambiar el estado del pedido -->
    <div class="mt-4">
        <h3>Cambiar Estado</h3>
        <div class="btn-group" role="group">
            <form method="POST" action="{{ route('pedidos.updateStatus', ['id' => $pedido->id]) }}">
                @csrf
                @method('PUT')
                <div class="btn-group" role="group" aria-label="Cambiar Estado">
                    <button type="submit" name="status" value="pendiente" class="btn btn-warning">Pendiente</button>
                    <button type="submit" name="status" value="completado" class="btn btn-success">Completado</button>
                    <button type="submit" name="status" value="cancelado" class="btn btn-danger">Cancelado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h3>Productos comprados</h3>
<table class="table table-striped table-bordered" id="tabla-producto">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio Unitario</th>
            <th>Precio Final</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedido->productos as $producto)
        <tr>
            <td>{{ $producto->nombre }}</td>
            <td>${{ $producto->precio }}</td>
            <td>${{ $producto->precio * $producto->cantidad }}</td> <!-- Calcula el Precio Final -->
            <td>{{ $producto->cantidad }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


<!-- Scripts  -->
<script type="module" src="{{ asset('assets/js/pages/pedidos/viewInit.js') }}"></script>

@endsection
