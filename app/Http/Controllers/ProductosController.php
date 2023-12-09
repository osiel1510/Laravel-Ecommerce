<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Cart;
use App\Models\Imagenproducto;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('productos.index',['user' => $user]);
    }

    public function view($id)
    {
        $categorias = Categoria::all();
        $producto = Producto::find($id);
        $user = Auth::user();
        $categorias = Categoria::all();
        $imagenes = Imagenproducto::where('producto_id', $producto->id)->get(); 
        
        if ($user != null){
            $carritos = Cart::where('user_id', $user->id)->get();
            $carrito = 0;
            foreach ($carritos as $carro) {
                $carrito += $carro->quantity;
            }
            return view('productos.view',['user' => $user, 'categorias' => $categorias,
            'producto' => $producto, 'imagenes' => $imagenes, 'carrito' => $carrito]);  
        } else {
            return view('productos.view',['user' => $user, 'categorias' => $categorias,
            'producto' => $producto, 'imagenes' => $imagenes]);  
        }
    }
    

    public function datatable()
    {
        $productos = Producto::query()->with('categoria'); // Cargar la relación 'categoria'
        return DataTables::eloquent($productos)->toJson();
    }

    public function imagenesDatatable($productoId)
    {
        $imagenes = Imagenproducto::query()->where('producto_id', $productoId); 
        return DataTables::eloquent($imagenes)->toJson();
    }

    public function agregarImagen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $producto = new Imagenproducto();
        $producto->producto_id = $request->input('id');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('public/productos', $fileName);
    
            $producto->path = basename($path);
        }

        $producto->save();

        return $this->responseMessage('Imagen agregada con éxito', $producto);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:productos',
            'image' => 'required|image',
            'stock' => 'required',
            'categoria_id' => 'required',
            'description' => '',
            'price' => 'required',
            'discount' =>'required',
            'destacado' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $producto = new Producto();
        $producto->name = $request->input('name');
        $producto->stock = $request->input('stock');
        $producto->categoria_id = $request->input('categoria_id');
        $producto->description = $request->input('description');
        $producto->price = $request->input('price');
        $producto->discount = $request->input('discount');
        $producto->destacado = $request->input('destacado');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('public/productos', $fileName);
    
            $producto->image = basename($path);
        }

        $producto->save();

        return $this->responseMessage('Producto creada con éxito', $producto);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categorias,name,' . $id,
            'image' => '',
            'stock' => 'required',
            'categoria_id' => 'required',
            'description' => '',
            'price' => 'required',
            'discount' =>'required',
            'destacado' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        
        $producto = Producto::find($id);
        $producto->name = $request->input('name');
        $producto->stock = $request->input('stock');
        $producto->categoria_id = $request->input('categoria_id');
        $producto->description = $request->input('description');
        $producto->price = $request->input('price');
        $producto->discount = $request->input('discount');
        $producto->destacado = $request->input('destacado');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('public/productos', $fileName);
    
            $producto->image = basename($path);
        }

        $producto->save();

        return $this->responseMessage('Producto creada con éxito', $producto);
    }
    
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $carts = Cart::where('producto_id', $producto->id)->get();
            $imagenProductos = Imagenproducto::where('producto_id', $producto->id)->get();

            foreach ($imagenProductos as $imagenp) {
                $imagePath = 'public/productos/' . $imagenp->path;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
                $imagenp->delete();
            }
            
            foreach ($carts as $cart) {
                $cart->delete();
            }

            if ($producto->image) {
                $imagePath = 'public/productos/' . $producto->image;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            
            $producto->delete();
            return $this->responseMessage('Producto eliminada con éxito', $producto);
    
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function list($categoriaId)
    {
        $categoria = Categoria::find($categoriaId);
        $productos = $categoria->productos()->orderBy('price', 'asc')->get();
        $categorias = Categoria::all();
    
        $user = Auth::user();
        $categorias = Categoria::all();
    
        if ($user != null){
            $carritos = Cart::where('user_id', $user->id)->get();
            $carrito = 0;
            foreach ($carritos as $carro) {
                $carrito += $carro->quantity;
            }
            return view('productos.list',['user' => $user, 'categorias' => $categorias,
            'productos' => $productos, 'categoriaSeleccionada' => $categoria, 
            'carrito' => $carrito]);
        } else {
            return view('productos.list',['user' => $user, 'categorias' => $categorias,
            'productos' => $productos, 'categoriaSeleccionada' => $categoria]);
        }
    }
    

    public function borrarImagen($id)
    {
        try {
            $producto = Imagenproducto::findOrFail($id);
            if ($producto->path) {
                $imagePath = 'public/productos/' . $producto->path;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            
            $producto->delete();
            return $this->responseMessage('Imagen eliminada con éxito', $producto);
    
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function show($id){
        try {
            $producto = Producto::where('id', $id)->with('categoria')->first();
            return $this->responseMessage("", $producto);
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    private function responseMessage($message, $data = "",  $code = 200){
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
