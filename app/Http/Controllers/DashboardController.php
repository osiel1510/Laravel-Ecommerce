<?php

namespace App\Http\Controllers;
use App\Http\Models\User;
use App\Models\Categoria;
use App\Models\Cart;
use App\Models\Producto;
use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        
        $user = Auth::user();
        $productos = Producto::where('destacado', 1)->orderBy('price', 'asc')->get();
        $categorias = Categoria::all();
        $anuncios = Anuncio::all();
    
        $categorias = Categoria::all();
    
        if ($user != null){
            $carritos = Cart::where('user_id', $user->id)->get();
            $carrito = 0;
            foreach ($carritos as $carro) {
                $carrito += $carro->quantity;
            }
            return view('dashboard.index',['user' => $user, 'categorias' => $categorias,
            'productos' => $productos, 'anuncios' => $anuncios,
            'carrito' => $carrito]);
        } else {
            return view('dashboard.index',['user' => $user, 'categorias' => $categorias,
            'productos' => $productos, 'anuncios' => $anuncios,]);
        }
    }
}
