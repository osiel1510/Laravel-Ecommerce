@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h2 id="title-page">Bienvenido a VikiTech</h2>
    </div>

    <div class="divider">
        <div></div>
    </div>

    @if (isset($user))

        @if ($user->role !== 'admin')
        <div class="divider">
        <div></div>
        </div>

        <style>

            #listing-div {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                width: 100%;
            }

            .listing-card {
                width: 30%;
                width: 
                display: flex;
                flex-direction: column;
                cursor: pointer;
                margin-right: 20px;
            }

            .product-name {
                font-weight: bold; /* Establece el texto en negrita */
                color: #333; /* Establece el color gris oscuro */
            }

            .price-div {
                display: flex;
                flex-direction: row;
            }

            .price {
                font-weight: bold;
                color: #00CCCC;
                font-size: 20px;
                margin-right: 10px;
            }

            .discount {
                color: #888888;
                text-decoration: line-through;
                margin-top: 3px;
            }

            .stock {
                font-size: 13px;
                display: flex;
                background: #00CCCC;
                flex-direction: row;
                color: white;
                font-weight: bold;
                margin: 0;
                width: fit-content;
                padding-right: 10px;
                height: fit-content;
            }

            .stock p {
                margin-bottom: 0;
                margin-left: 3px;
            }

            .stock i {
                margin-left: 3px;
            }

            .no-stock {
                background: #888888;
            }
        </style>

        
        <div class="owl-carousel">
            @foreach ($anuncios as $anuncio)
                <div class="item">
                    <img src="/storage/anuncios/{{ $anuncio->path }}" alt="Anuncio">
                </div>
            @endforeach
        </div>

        <div id="listing-div">
            @foreach ($productos as $producto)
                <div class="listing-card" href="/productos/view/{{$producto->id}}">
                    <img src="/storage/productos/{{$producto->image}}" style="max-width: 220px; max-height: 220px;">
                    <p class="product-name">{{$producto->name}}</p>
                    <div class="price-div">
                        @if ($producto->discount > 0)
                            <p class="price">${{$producto->discount}}</p>
                            <p class="discount">${{ $producto->price }}</p>
                        @else
                            <p class="price">${{$producto->price}}</p>
                        @endif
                    </div>
                    @if ($producto->stock > 0)
                        <div class="stock">
                            <i class="bi bi-check-lg"></i> <p>CON EXISTENCIA</p>
                        </div>
                    @else
                        <div class="stock no-stock">
                            <i class="bi bi-exclamation-lg"></i> <p>BAJO PEDIDO</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function(){
                $(".owl-carousel").owlCarousel({
                    items: 1, // Número de elementos por diapositiva
                    autoplay: true, // Reproducción automática
                    autoplayTimeout: 3000, // Tiempo de espera entre diapositivas en milisegundos
                    loop: true, // Bucle infinito
                    nav: false, // Ocultar controles de navegación
                    dots: true // Mostrar indicadores de navegación
                });
            });
        </script>


        <script>
            const listingCards = document.querySelectorAll('.listing-card');

            // Aplica un evento click a cada elemento
            listingCards.forEach(function(listingCard) {
                listingCard.addEventListener('click', function() {
                    window.location.href = this.getAttribute('href');
                });
            });
        </script>
        @endif

    @else 
    <div class="divider">
        <div></div>
        </div>

        <style>

            #listing-div {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                width: 100%;
            }

            .listing-card {
                width: 30%;
                width: 
                display: flex;
                flex-direction: column;
                cursor: pointer;
                margin-right: 20px;
            }

            .product-name {
                font-weight: bold; /* Establece el texto en negrita */
                color: #333; /* Establece el color gris oscuro */
            }

            .price-div {
                display: flex;
                flex-direction: row;
            }

            .price {
                font-weight: bold;
                color: #00CCCC;
                font-size: 20px;
                margin-right: 10px;
            }

            .discount {
                color: #888888;
                text-decoration: line-through;
                margin-top: 3px;
            }

            .stock {
                font-size: 13px;
                display: flex;
                background: #00CCCC;
                flex-direction: row;
                color: white;
                font-weight: bold;
                margin: 0;
                width: fit-content;
                padding-right: 10px;
                height: fit-content;
            }

            .stock p {
                margin-bottom: 0;
                margin-left: 3px;
            }

            .stock i {
                margin-left: 3px;
            }

            .no-stock {
                background: #888888;
            }
        </style>

        
        <div class="owl-carousel">
            @foreach ($anuncios as $anuncio)
                <div class="item">
                    <img src="/storage/anuncios/{{ $anuncio->path }}" alt="Anuncio">
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between">
            <h2 id="title-page">Productos destacados</h2>
        </div>

        <div class="divider">
            <div></div>
        </div>

        <div id="listing-div">
            @foreach ($productos as $producto)
                <div class="listing-card" href="/productos/view/{{$producto->id}}">
                    <img src="/storage/productos/{{$producto->image}}" style="max-width: 220px; max-height: 220px;">
                    <p class="product-name">{{$producto->name}}</p>
                    <div class="price-div">
                        @if ($producto->discount > 0)
                            <p class="price">${{$producto->discount}}</p>
                            <p class="discount">${{ $producto->price }}</p>
                        @else
                            <p class="price">${{$producto->price}}</p>
                        @endif
                    </div>
                    @if ($producto->stock > 0)
                        <div class="stock">
                            <i class="bi bi-check-lg"></i> <p>CON EXISTENCIA</p>
                        </div>
                    @else
                        <div class="stock no-stock">
                            <i class="bi bi-exclamation-lg"></i> <p>BAJO PEDIDO</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function(){
                $(".owl-carousel").owlCarousel({
                    items: 1, // Número de elementos por diapositiva
                    autoplay: true, // Reproducción automática
                    autoplayTimeout: 3000, // Tiempo de espera entre diapositivas en milisegundos
                    loop: true, // Bucle infinito
                    nav: false, // Ocultar controles de navegación
                    dots: true // Mostrar indicadores de navegación
                });
            });
        </script>


        <script>
            const listingCards = document.querySelectorAll('.listing-card');

            // Aplica un evento click a cada elemento
            listingCards.forEach(function(listingCard) {
                listingCard.addEventListener('click', function() {
                    window.location.href = this.getAttribute('href');
                });
            });
        </script>
    @endif

@endsection