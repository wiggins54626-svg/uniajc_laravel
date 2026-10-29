<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Empresa;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::all(['id_empresa', 'nombre']);
        return view('usuarios.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        'username' => 'required|unique:usuario',
        'password' => 'required',
        'rol' => 'required'
    ]);

    Usuario::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'rol' => $request->rol,
        'activo' => $request->activo,
        'fecha_creacion' => now(),
        'id_empresa' => $request->id_empresa
    ]);

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario creado correctamente'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        $empresas = Empresa::all(['id_empresa', 'nombre']);
        return view('usuarios.edit', compact('usuario', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $usuario->update([
        'username' => $request->username,
        'rol' => $request->rol,
        'activo' => $request->activo,
        'id_empresa' => $request->id_empresa
    ]);

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
         $usuario->delete();

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario eliminado correctamente');
    }
}
