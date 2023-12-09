<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaestrosController;
use App\Http\Controllers\SalonesController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\DispositivosController;
use App\Http\Controllers\HorasController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\AnunciosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** Login */
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'registerIndex'])->name('register');
/***/

/** Dashboard */
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
/***/

/** Categorías */
Route::get('/categorias/datatable', [CategoriasController::class, 'datatable']);
Route::get('/categorias/all', [CategoriasController::class, 'all']);
Route::resource('categorias', CategoriasController::class)->only([
    'index','store', 'destroy','show','update'
]);
/***/

/** Usuarios */
Route::post('/users/client', [UsersController::class, 'storeClient'])->name('storeClient');
Route::get('/users/datatable', [UsersController::class, 'datatable']);
Route::resource('users', UsersController::class)->only([
    'index','store', 'destroy','show','update'
]);
/***/

/** Marcas */
Route::get('/marcas/datatable', [MarcasController::class, 'datatable']);
Route::resource('marcas', MarcasController::class)->only([
    'index','store', 'destroy','show','update'
]);
/***/

/** Carts */
Route::post('/carts/updateItem', [CartsController::class, 'updateItem']);
Route::get('/carts/actualCart', [CartsController::class, 'getActualCart']);
Route::resource('carts', CartsController::class)->only([
    'store', 'index', 'destroy'
]);
/***/

/** Pedidos */
Route::put('/pedidos/updateStatus/{id}', [PedidosController::class, 'updateStatus'])->name('pedidos.updateStatus');
Route::get('/pedidos/view/{id}', [PedidosController::class, 'view'])->name('pedidos.view');
Route::get('/pedidos/datatable', [PedidosController::class, 'datatable']);
Route::get('/pedidos/create', [PedidosController::class, 'create']);
Route::resource('pedidos', PedidosController::class)->only([
    'store', 'index'
]);
/***/

/** Anuncios */
Route::get('/anuncios/datatable', [AnunciosController::class, 'datatable']);
Route::resource('anuncios', AnunciosController::class)->only([
    'store', 'index', 'destroy'
]);
/***/

/** Productos */
Route::get('/productos/view/{id}', [ProductosController::class, 'view']);
Route::get('/productos/list/{categoriaId}', [ProductosController::class, 'list'])->name('productos.list');
Route::delete('/productos/imagenes/{id}', [ProductosController::class, 'borrarImagen']);
Route::post('/productos/imagenes/', [ProductosController::class, 'agregarImagen']);
Route::get('/productos/imagenes/datatable/{productoId}', [ProductosController::class, 'imagenesDatatable']);
Route::get('/productos/datatable', [ProductosController::class, 'datatable']);
Route::resource('productos', ProductosController::class)->only([
    'index','store', 'destroy','show','update'
]);
/***/