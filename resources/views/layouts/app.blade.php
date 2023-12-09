<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VikiTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

        #myChart {
            width: 400px;
            height: 300px;
        }


        .dataTables_wrapper .paginate_button {
            padding: 5px 10px;
            margin-right: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .divider {
            width: 100%;
            display:flex;
            flex-direction: row;
            justify-content: center;
        }

        .divider div {
            height: 2px;
            width: 100%;
            border-bottom: 2px solid #CCCCCC;
        }

        .dataTables_wrapper .paginate_button:hover {
            background-color: #333;
            color: #fff;
            border-color: #333;
        }

        .custom-toast-success {
            background-color: #4CAF50;
            color: #fff;
        }

        .custom-toast-error {
            background-color: #FF5722;
            color: #fff;
        }


        #title-page{
            margin-top: 30px;
            color: #292b2c;
        }

        .table{
            margin-top: 30px;
        }

        .active {
            color: #fff !important; 
        }

        /* Estilos personalizados para la barra lateral */
        #sidebar {
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Ancho de la barra lateral */
            background-color: #292b2c; /* Color de fondo de la barra lateral */
            color: #ccc;
        }

        #sidebar ul.components {
            padding: 20px;
        }

        /* Estilos para los enlaces en la barra lateral */
        #sidebar ul li {
            padding: 10px;
            text-decoration: none;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            transition: color 0.3s; /* Transición para el cambio de color de texto */
        }

        /* Iconos de Bootstrap Icons */
        #sidebar ul li i {
            font-size: 1.5em;
            margin-right: 10px;
        }

        /* Cambiar el color del texto cuando se pasa el cursor */
        #sidebar ul li:hover {
            color: #f8f9fa; /* Color de texto más claro al pasar el cursor */
        }

        /* Ajustar el contenido principal para dejar espacio para la barra lateral */
        #content {
            margin-left: 250px; /* Ancho de la barra lateral */
            padding: 20px;
        }

        /* Estilo para el encabezado de la barra lateral */
        .sidebar-header {
            padding: 20px;
            background-color: #292b2c;
        }

        /* Estilo para el texto del encabezado */
        .sidebar-header h3 {
            color: #ccc;
        }

        #sidebar ul li a {
            text-decoration: none;
            color: #ccc;

        }

        #sidebar ul li a:hover {
            color: #f8f9fa;
        }

        .scrollable-modal .modal-dialog {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Estilos personalizados para las tarjetas */
        .card {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .card-body {
        padding: 10px;
        }

        /* Opcional: Estilos para resaltar las tarjetas de asistencia */
        .card-success {
        border-color: #28a745;
        background-color: #dff0d8;
        }
        .card-warning {
        border-color: #ffc107;
        background-color: #fff3cd;
        }

        #tabla-asistencias {
            margin-top: 10px;
        }

        /* Estilo para las asistencias */
        .asistencia.asistido-true {
            background-color: #4CAF50; /* Fondo verde para asistencias */
            color: #fff; /* Texto blanco */
        }

        /* Estilo para las no asistencias */
        .asistencia.asistido-false {
            background-color: #FF5722; /* Fondo naranja para no asistencias */
            color: #fff; /* Texto blanco */
        }

        /* Estilo común para todas las asistencias */
        .asistencia {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
        }

    </style>

</head>
<body>
    <!-- Barra de navegación lateral izquierda -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <img src="/storage/imagenes/bannerhorizontal.png" style="max-width: 220px">
        </div>
        <ul class="list-unstyled components">
            @auth

            @if ($user->role == 'admin')
                <li>
                <a href="{{ route('users.index') }}" class="{{ request()->is('users') ? 'active' : '' }}">
                        <i class="bi bi-person-raised-hand"></i> Usuarios
                    </a>
                </li>
                <li>
                <a href="{{ route('pedidos.index') }}" class="{{ request()->is('pedidos') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Pedidos
                    </a>
                </li>
                <li>
                <a href="{{ route('anuncios.index') }}" class="{{ request()->is('anuncios') ? 'active' : '' }}">
                        <i class="bi bi-badge-ad"></i> Anuncios
                    </a>
                </li>
                <li>
                <a href="{{ route('categorias.index') }}" class="{{ request()->is('categorias') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i> Categorías
                    </a>
                <!-- </li>
                <li>
                    <a href="{{ route('marcas.index') }}" class="{{ request()->is('marcas') ? 'active' : '' }}">
                        <i class="bi bi-amd"></i> Marcas
                    </a>
                </li> -->
                <li>
                <a href="{{ route('productos.index') }}" class="{{ request()->is('productos') ? 'active' : '' }}">
                        <i class="bi bi-gpu-card"></i> Productos
                    </a>
                </li>
            @endif
            
            @if ($user->role == 'client')
                <li>
                    <a href="{{ route('dashboard')}}">
                        Inicio
                    </a>
                </li>
                @if (isset($categorias))
                @foreach ($categorias as $categoria)
                    @if ($categoria->productos->count() > 0)
                        <li>
                            <a href="{{ route('productos.list', ['categoriaId' => $categoria->id]) }}">
                                {{ $categoria->name }}
                            </a>
                        </li>
                    @endif
                @endforeach
                @endif
            @endif

            @endauth

            @guest
                <li>
                    <a href="{{ route('dashboard')}}">
                        Inicio
                    </a>
                </li>
                @if (isset($categorias))
                    @foreach ($categorias as $categoria)
                        <li>
                        <a href="{{ route('productos.list', ['categoriaId' => $categoria->id]) }}">
                                {{$categoria->name}}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endguest
        </ul>
    </nav>

    
    <!-- Contenido principal -->
    <div id="content">
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            @guest
            <div class="d-flex align-items-center ml-auto">
                <form action="{{ route('login') }}" method="GET">
                    <button type="submit" class="btn btn-success ml-3">Iniciar Sesión</button>
                </form>
            </div>
            @endguest
            
            @auth
            <div class="d-flex align-items-center ml-auto">
                @if (isset($carrito))
                <span class="mr-2 view-cart" id="cart-counter" style="cursor: pointer;" href="">{{$carrito}}</span>
                <i style="margin-right: 20px; cursor:pointer;" class="bi bi-cart-fill view-cart"></i>
                @endif
                <span class="mr-2">{{$user->name}}</span>
                <i class="bi bi-person"></i>
                <form action="{{ route('logout') }}" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="btn btn-danger ml-3">Cerrar Sesión</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    </div>

    <!-- Agrega enlaces a los archivos JavaScript de Bootstrap y jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/plugins/toast/toast.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script>
        // Paso 1: Selecciona todos los elementos con la clase "view-cart"
        const viewCartElements = document.querySelectorAll(".view-cart");

        // Paso 2: Agrega un evento click a cada elemento y redirecciona a otra página
        viewCartElements.forEach(element => {
        element.addEventListener("click", () => {
            // Redireccionar a la página deseada (reemplaza 'nueva_pagina.html' con tu URL)
            window.location.href =  "/carts";
        });
        });
    </script>

</body>
</html>
                