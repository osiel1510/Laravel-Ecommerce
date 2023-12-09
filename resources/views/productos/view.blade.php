@extends('layouts.app')

@section('content')
    <style>

        .product-name {
            font-weight: bold; /* Establece el texto en negrita */
            color: #333; /* Establece el color gris oscuro */
            font-size: 24px;
        }

        .available {
            font-weight: bold; /* Establece el texto en negrita */
            color: #333; /* Establece el color gris oscuro */
            margin-right: 20px;
        }

        .description {
            color: #777; /* Establece el color gris oscuro */
            font-size: 16px;
        }

        .stock {
            color: #FF0F0F;
        }

        .price-div {
            display: flex;
            flex-direction: row;
        }

        .price {
            font-weight: bold;
            color: #00CCCC;
            font-size: 36px;
            margin-right: 20px;
        }

        .discount {
            color: #888888;
            text-decoration: line-through;
            margin-top: 3px;
            font-size: 26px;
        }

        .stock p {
            margin-bottom: 0;
            margin-left: 3px;
        }

        #product-card {
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin-top: 30px;
            width: 100%;
            margin-bottom: 20px;
        }

        #product-description {
            display: flex;
            flex-direction: column;
        }

        .listing-card {
            width: 30%;
            width: 
            display: flex;
            flex-direction: column;
            margin-right: 20px;
        }

        .stock-container {
            display: flex;
        }

        #imagenes {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        #add-to-cart {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        #add-to-cart p {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
            margin-top: 10px;
        }

        #button-cart {
            color: white;
            background: #888888;
            border: none;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px; /* Redondea los bordes del botón */
            transition: background 0.3s; /* Agrega una transición al cambio de color */
        }

        #button-cart:hover {
            background: #00CCCC;
        }


    </style>

    <div id="product-card">
        <img src="/storage/productos/{{$producto->image}}" style="padding-right: 30px; max-width: 400px; max-height: 400px;">
        <div class="listing-card" href="/productos/view/{{$producto->id}}">
            <p class="product-name">{{$producto->name}}</p>
            <div class="stock-container">
                <p class="available">DISPONIBLES: </p>
                <p class="stock">{{$producto->stock}}</p>    
            </div>
            <p class="description">{{$producto->description}}</p>
            <div class="price-div">
                @if ($producto->discount > 0)
                        <p class="price">${{$producto->discount}}</p>
                        <p class="discount">${{ $producto->price }}</p>
                    @else
                        <p class="price">${{$producto->price}}</p>
                    @endif
            </div>
            @guest
                <div id="add-to-cart">
                    <p>CANTIDAD:</p>
                    <div class="input-group">
                        <input id="product-id" type="hidden" value="{{$producto->id}}">
                        <input id="quantity" type="number" class="form-control" min="1" max="{{ $producto->stock }}" value="1">
                    </div>
                </div>
                <button id="button-cart" data-id="-1" ><i class="bi bi-cart-fill" style="margin-right: 10px;"></i>Agregar al carrito</button>
            @endguest

            @auth
                <div id="add-to-cart">
                    <p>CANTIDAD:</p>
                    <div class="input-group">
                        <input id="product-id" type="hidden" value="{{$producto->id}}">
                        <input id="quantity" type="number" class="form-control" min="1" max="{{ $producto->stock }}" value="1">
                    </div>
                </div>
                    <button id="button-cart" data-id="{{$user->id}}"><i class="bi bi-cart-fill" style="margin-right: 10px;"></i>Agregar al carrito</button>
            @endauth
            </div>
    </div>
    <div class="divider">
        <div></div>
    </div>
    <div id="imagenes">
        @foreach ($imagenes as $imagen)
            <img src="/storage/productos/{{$imagen->path}}" style="padding-right: 30px; max-width: 400px; max-height: 400px;">
        @endforeach
    </div>    
    
    <!-- Scripts  -->
    <script type="module" src="{{ asset('assets/js/pages/productos/addToCart.js') }}"></script>

@endsection