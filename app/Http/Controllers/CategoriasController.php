<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoriasController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('categorias.index',['user' => $user]);
    }

    public function datatable()
    {
        $categorias = Categoria::query();
        return DataTables::eloquent($categorias)->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categorias'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $categoria = new Categoria();
        $categoria->name = $request->input('name');
        $categoria->save();

        return $this->responseMessage('Categoría creada con éxito', $categoria);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categorias,name,' . $id,
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $categoria->name = $request->input('name');
        $categoria->save();

        return $this->responseMessage('Categoria actualizada con éxito', $categoria);
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return $this->responseMessage('Categoria eliminado con éxito', $categoria);
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function show($id){
        try {
            $categoria = Categoria::where('id', $id)->first();
            return $this->responseMessage("", $categoria);
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function all()
    {
        // Obtener todas las categorías de la base de datos
        $categorias = Categoria::all();

        // Devolver las categorías como respuesta JSON
        return response()->json($categorias);
    }

    private function responseMessage($message, $data = "",  $code = 200){
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
    
}
