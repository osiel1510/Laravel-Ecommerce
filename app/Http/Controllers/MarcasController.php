<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Marca;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class MarcasController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('marcas.index',['user' => $user]);
    }

    public function datatable()
    {
        $marcas = Marca::query();
        return DataTables::eloquent($marcas)->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:marcas',
            'image' => 'required|image', 
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $marca = new Marca();
        $marca->name = $request->input('name');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs('public/marcas', $fileName);
    
            $marca->image = basename($path);
        }

        $marca->save();

        return $this->responseMessage('Marca creada con éxito', $marca);
    }


    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:marcas,name,' . $id,
            'image' => 'image',
        ]);
    
        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }
    
        $marca->name = $request->input('name');
    
        if ($request->hasFile('image')) {
            if ($marca->image) {
                $oldImagePath = 'public/marcas/' . $marca->image;
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }
    
            $imagePath = $request->file('image')->store('public/marcas');
            $marca->image = basename($imagePath);
        }
    
        $marca->save();
    
        return $this->responseMessage('Marca actualizada con éxito', $marca);
    }
    
    public function destroy($id)
    {
        try {

            $marca = Marca::findOrFail($id);
            if ($marca->image) {
                $imagePath = 'public/marcas/' . $marca->image;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            
            $marca->delete();
            return $this->responseMessage('Marca eliminada con éxito', $marca);
    
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function show($id){
        try {
            $marca = Marca::where('id', $id)->first();
            return $this->responseMessage("", $marca);
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
