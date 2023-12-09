<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('users.index',['user' => $user]);
    }

    public function datatable()
    {
        $users = User::query();
        return DataTables::eloquent($users)->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return $this->responseMessage('Usuario creado con éxito', $user);
    }

    public function storeClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'client';
        $user->save();

        return $this->responseMessage('Registro exitoso', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|confirmed',
            'role' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->responseMessage($validator->errors(), "", 400);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        if(!empty($request->input('password'))){
            $user->password = Hash::make($request->input('password'));
        }
        
        $user->role = $request->input('role');
        $user->save();

        return $this->responseMessage('Usuario actualizado con éxito', $user);
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $carritos = Cart::where('user_id', $user->id);
            foreach ($carritos as $carrito) {
                $carrito->delete();
            }
            $user->delete();
            return $this->responseMessage('Usuario eliminado con éxito', $user);
        } catch (\Exception $error) {
            return $this->responseMessage($error->getMessage(), "", 400);
        }
    }

    public function show($id){
        try {
            $user = User::where('id', $id)->first();
            return $this->responseMessage("", $user);
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
