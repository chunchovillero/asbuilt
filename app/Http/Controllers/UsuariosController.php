<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=Usuario::get();
        return view('adminlte::usuarios.index', compact('usuarios'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|unique:User,user_email'
        ]);
        $usuario = new Usuario();
        $usuario -> user_email = $request->email;
        $usuario -> user_name = $request->nombre;
        $usuario -> user_last_name = $request->apellido;
        $usuario -> user_phone = $request->telefono;
        $usuario -> user_position = $request->posicion;
        $usuario -> user_admin = $request->admin;
        $usuario -> user_credit = $request->creditos;
        $usuario -> user_password = Hash::make($request->password);
        $usuario -> user_upd_tsp = \strtotime("now");
        $usuario -> save();

        return redirect('usuarios')->with('message', 'Se ha creado un nuevo usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = Usuario::where('user_id', $id)->first();
        
        return view('adminlte::usuarios.edit')->with(['usuario'=> $usuario]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $usuario->user_name = $request->nombre;
        $usuario->user_last_name = $request->apellido;
        $usuario->user_email = $request->email;
        $usuario->user_phone = $request->telefono;
        $usuario->user_position = $request->posicion;
        $usuario->user_admin = $request->admin;
        $usuario->user_credit = $request->creditos;
        if($request->password!=''){
        $usuario->user_password = Hash::make($request->password);
        };
        $usuario->user_upd_tsp = \strtotime("now");
        $usuario->save();

        return redirect()->route('usuarios.edit', ['id' => $usuario->user_id])->with('message', 'Se ha editado el usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


        public function EliminarUsuario($userid){
        Usuario::where('user_id', $userid)->delete();

       return redirect()->route('usuarios.index')->with('message', 'Se ha eliminado el usuario');
    }

}
