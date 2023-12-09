<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cart;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CartsController extends Controller
{

    public function index(){
        $this->verifyStock();
        $user = Auth::user();
        $categorias = Categoria::all();
        $carritos = Cart::where('user_id', $user->id)->get();
        $carrito = 0;
        foreach ($carritos as $carro) {
            $carrito += $carro->quantity;
        }
        return view('carts.index',['user' => $user, 'categorias' => $categorias, 
            'carrito' => $carrito]);
    }

    public function getActualCart () {
        $user = auth()->user();
        $carritos = Cart::where('user_id', $user->id)->with('producto');
        return DataTables::eloquent($carritos)->toJson();
    }

    public function updateItem (Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $this->verifyStock();

        $user = auth()->user();

        $carrito = Cart::where('user_id', $user->id)->where('producto_id', $request->input('id'))->first();
        
        if($carrito->producto->stock < $request->input('value')) {
            return $this->responseMessage("Stock excedido!", "", 400);
        }
        
        $carrito->quantity = $request->input('value');
        $carrito->save();

        $carts = Cart::where('user_id', $user->id)->get();
        $numCarts = 0;
        foreach ($carts as $carrito) {
           $numCarts += $carrito->quantity; 
        }

        return $this->responseMessage('Producto agregado con éxito', $numCarts);
    }

    public function destroy($id)
    {
        try {
            $carrito = Cart::findOrFail($id);
            $user_id = $carrito->user_id;
            $carrito->delete();
            
            $carts = Cart::where('user_id', $user_id)->get();
            $numCarts = 0;
            foreach ($carts as $carrito) {
               $numCarts += $carrito->quantity; 
            }
    
            return $this->responseMessage('Producto eliminado con éxito', $numCarts);
    
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    private function verifyStock(){
        $user = auth()->user();
        $carritos = Cart::where('user_id', $user->id)->with('producto')->get();

        foreach ($carritos as $carrito) {
            if($carrito->producto->stock <= 0) {
                $carrito->delete();
            } else {
                if($carrito->quantity > $carrito->producto->stock){
                    $carrito->quantity = $carrito->producto->stock;
                    $carrito->save();
                }
            }
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required',
            'quantity' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $producto = Producto::find($request->input('producto_id'));
        $carritosActuales = Cart::where('user_id', $request->input('user_id'))
        ->where('producto_id', $request->input('producto_id'))->first();
    
        $numCarts = 0;
        if ($carritosActuales) {
            $numCarts = $carritosActuales->quantity;
        }
        
        $cart = null;
        if($numCarts + $request->input('quantity') <= $producto->stock){
            if($numCarts > 0) {
                $carritosActuales->quantity = $carritosActuales->quantity + $request->input('quantity');
                $carritosActuales->save();
                $cart = $carritosActuales;
            } else {
                $cart = new Cart();
                $cart->producto_id = $request->input('producto_id');
                $cart->user_id = $request->input('user_id');
                $cart->quantity = $request->input('quantity');
        
                $cart->save();   
            }
    
            $carts = Cart::where('user_id', $cart->user_id)->get();
            $numCarts = 0;
            foreach ($carts as $carrito) {
               $numCarts += $carrito->quantity; 
            }  
    
            return $this->responseMessage('Producto agregado con éxito', $numCarts);
        } else {
            return $this->responseMessage('Se excedió el limite de pedidos de este producto', "", 400);
        }
    }

    private function responseMessage($message, $data = "",  $code = 200){
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
    
}
