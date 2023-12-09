<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Models\Cart;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{

    public function index(){
        $user = Auth::user();
        return view('pedidos.index',['user' => $user]);
    }

    public function datatable()
    {
        // Obtener los pedidos pendientes primero
        $pedidosPendientes = Pedido::with('productos')
            ->where('status', 'pendiente')
            ->orderBy('updated_at', 'desc')
            ->get();
    
        // Obtener los demás pedidos
        $otrosPedidos = Pedido::with('productos')
            ->where('status', '<>', 'pendiente')
            ->orderBy('updated_at', 'desc')
            ->get();
    
        // Fusionar los resultados en una sola colección
        $pedidos = $pedidosPendientes->concat($otrosPedidos);
        
        return DataTables::of($pedidos)->toJson();
    }

    public function updateStatus(Request $request, $id)
{
    // Obtén el pedido por su ID
    $pedido = Pedido::findOrFail($id);

    // Valida que el estado enviado sea uno de los estados permitidos (pendiente, completado, cancelado)
    $request->validate([
        'status' => 'required|in:pendiente,completado,cancelado',
    ]);

    // Actualiza el estado del pedido con el valor enviado desde el formulario
    $pedido->status = $request->input('status');
    $pedido->save();

    // Redirige de vuelta a la página del pedido con un mensaje de éxito
    return redirect()->route('pedidos.view', ['id' => $pedido->id])->with('success', 'Estado del pedido actualizado correctamente');
}


    public function view ($id) 
    {
        $pedido = Pedido::where('id', $id)->with('productos')->first();
        $total = $pedido->calcularTotal();
        $user = Auth::user();

        return view('pedidos.view',['user' => $user, 'pedido' => $pedido, 'total' => $total]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'calle' => 'required|string',
            'cp' => 'required|string',
            'numero_interior' => 'required|string',
            'municipio' => 'required|string',
            'estado' => 'required|string',
            'numero_telefonico' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();

            $pedido = new Pedido();
            $pedido->nombre = $request->input('nombre');
            $pedido->calle = $request->input('calle');
            $pedido->cp = $request->input('cp');
            $pedido->numero_interior = $request->input('numero_interior');
            $pedido->municipio = $request->input('municipio');
            $pedido->estado = $request->input('estado');
            $pedido->numero_telefonico = $request->input('numero_telefonico');
            $pedido->correo = $user->email;
            $pedido->save();

            $productos = Cart::where('user_id', $user->id)->with('producto')->get();

            foreach ($productos as $producto) {
                $nuevoProducto = new PedidoProducto();
                $producto->producto->stock = $producto->producto->stock - $producto->quantity;
                $producto->producto->save();
                $nuevoProducto->nombre = $producto->producto->name;
                $nuevoProducto->precio = $producto->producto->price;
                $nuevoProducto->precio = $producto->producto->price;
                $nuevoProducto->cantidad = $producto->quantity;
                $nuevoProducto->id_pedido = $pedido->id;
                $nuevoProducto->save();
                $producto->delete();
            }

            DB::commit();

            return $this->responseMessage('Pedido registrado con éxito', $pedido->id);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseMessage($e->getMessage(), "", 400);
        }
    }

    public function create()
    {
        $categorias = Categoria::all();
        $user = Auth::user();

        if ($user != null){
            $carritos = Cart::where('user_id', $user->id)->get();
            $carrito = 0;
            foreach ($carritos as $carro) {
                $carrito += $carro->quantity;
            }
            return view('pedidos.create',['user' => $user, 'categorias' => $categorias,
            'carrito' => $carrito]);
        } else {
            return view('pedidos.create',['user' => $user, 'categorias' => $categorias]);
        }
    }

    private function responseMessage($message, $data = "",  $code = 200){
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
