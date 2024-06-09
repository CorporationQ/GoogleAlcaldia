<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index',['usuarios'=>$usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->save();

        $usuario->assignRole('usuario');

        return redirect()->route('usuarios.index')
            ->with('mensaje','Se registro al usuario de la manera correcta')
            ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view ('admin.usuarios.show',['usuario'=>$usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view ('admin.usuarios.edit',['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('mensaje','Se actualizó al usuario de la manera correcta')
            ->with('icono','success');

    }

    /**
     * Elimine el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('usuarios.index')
            ->with('mensaje','Se eliminó al usuario de la manera correcta')
            ->with('icono','success');
    }
 

     public function registro(){
        return view(view:'auth.registro');

     }


     public function registro_create(Request $request)
     {
         //$datos = request()->all();
         //return response()->json($datos);
 
         $request->validate([
             'name' => 'required|max:100',
             'email' => 'required|unique:users',
             'password' => 'required|confirmed',
         ]);
 
         $usuario = new User();
         $usuario->name = $request->name;
         $usuario->email = $request->email;
         $usuario->password = Hash::make($request['password']);
         $usuario->save();
         
         Auth::login($usuario);
 
         return redirect('/')
             ->with('mensaje','Registro Exitoso - Bienvenido al Sistema')
             ->with('icono','success');
 
     }
 

 }