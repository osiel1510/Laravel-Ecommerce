<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Anuncio;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class AnunciosController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('anuncios.index',['user' => $user]);
    }

    public function datatable()
    {
        $imagenes = Anuncio::query();
        return DataTables::eloquent($imagenes)->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $anuncio = new Anuncio();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('public/anuncios', $fileName);
    
            $anuncio->path = basename($path);
        }

        $anuncio->save();

        return $this->responseMessage('Anuncio agregado con éxito', $anuncio);
    }

    public function destroy($id)
    {
        try {
            $anuncio = Anuncio::findOrFail($id);
            if ($anuncio->path) {
                $imagePath = 'public/anuncios/' . $anuncio->path;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            
            $anuncio->delete();
            return $this->responseMessage('Imagen eliminada con éxito', $anuncio);
    
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
