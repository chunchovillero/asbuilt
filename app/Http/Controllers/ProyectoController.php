<?php

namespace App\Http\Controllers;

use App\Proyecto;
use App\Userproject;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Mail;
Use App\Mail\Welcome;
Use Auth;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos=Proyecto::with('usuarios')->get();
        return view('adminlte::proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        return view('adminlte::proyectos.create');
    }

    public function store(Request $request)
    {
        $proyectos = new Proyecto();
        $proyectos -> pro_name = $request->nombreproyecto;
        $proyectos -> pro_company = $request->nombreempresa;
        $proyectos -> pro_latitude = $request->latitud;
        $proyectos -> pro_longitude = $request->longitud;
        $proyectos -> pro_address = $request->direccion;
        $proyectos -> pro_upd_tsp = \strtotime("now");
        $proyectos -> save();

        $idproyecto=$proyectos->pro_id;

//Se crea la tabla floor_(id del proyecto)
        Schema::create('Floor_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->increments('flo_id');
            $table->string('flo_name', 150);
            $table->integer('flo_pro_id')->unsigned();
            $table->foreign('flo_pro_id')->references('pro_id')->on('Project')->onDelete('cascade');
            $table->integer('flo_upd_tsp');
        });

//Se crea la tabla section_($id del proyectos)
        Schema::create('Section_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->increments('sec_id');
            $table->string('sec_name', 150);
            $table->integer('sec_flo_id')->unsigned();
            $table->foreign('sec_flo_id')->references('flo_id')->on('Floor_'.$idproyecto)->onDelete('cascade');
            $table->integer('sec_upd_tsp');
        });

//Se crea la tabla dacility(id del proyecto)
        Schema::create('Facility_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->increments('fac_id');
            $table->string('fac_name', 150);
            $table->integer('fac_sec_id')->unsigned();
            $table->foreign('fac_sec_id')->references('sec_id')->on('Section_'.$idproyecto)->onDelete('cascade');
            $table->integer('fac_upd_tsp');
        });

//Se crea la tabla delete(id del proyecto)
        Schema::create('Delete_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->integer('del_flo_id')->unsigned()->nullable();
            $table->integer('del_sec_id')->unsigned()->nullable();
            $table->integer('del_fac_id')->unsigned()->nullable();
            $table->integer('del_doc_id')->unsigned()->nullable();
            $table->integer('del_com_id')->unsigned()->nullable();
            $table->integer('del_TIMESTAMP')->nullable(false);
            $table->integer('del_user_id')->unsigned()->nullable();
        });

//Se crea la tabla document(id del proyecto)
        Schema::create('Document_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->increments('doc_id');   
            $table->string('doc_text', 200);
            $table->string('doc_file_path', 400);
            $table->string('doc_name', 20);
            $table->datetime('doc_date');
            $table->integer('doc_type');
            $table->integer('doc_owner_id')->unsigned()->nullable();
            $table->foreign('doc_owner_id')->references('user_id')->on('User')->onDelete('restrict');
            $table->integer('doc_flo_id')->unsigned()->nullable();
            $table->foreign('doc_flo_id')->references('flo_id')->on('Floor_'.$idproyecto)->onDelete('cascade');
            $table->integer('doc_sec_id')->unsigned()->nullable();
            $table->foreign('doc_sec_id')->references('sec_id')->on('Section_'.$idproyecto)->onDelete('cascade');
            $table->integer('doc_fac_id')->unsigned()->nullable();
            $table->foreign('doc_fac_id')->references('fac_id')->on('Facility_'.$idproyecto)->onDelete('cascade');
            $table->integer('doc_upd_tsp');
            $table->integer('doc_pro_id')->unsigned()->nullable();
            $table->foreign('doc_pro_id')->references('pro_id')->on('Project')->onDelete('restrict');
            $table->text('doc_metadata');
        });

//Se crea la tabla comment(id del proyecto)
        Schema::create('Comment_'.$idproyecto, function (Blueprint $table) use ($idproyecto) {
            $table->increments('com_id');
            $table->datetime('com_date');
            $table->text('com_text')->nullable();
            $table->string('com_file_path', 400)->nullable();
            $table->string('com_metadata', 100)->nullable();
            $table->integer('com_parent_id')->unsigned()->nullable();
            $table->integer('com_owner_id')->unsigned();
            $table->foreign('com_owner_id')->references('user_id')->on('User');
            $table->integer('com_fac_id')->unsigned();
            $table->foreign('com_fac_id')->references('fac_id')->on('Facility_'.$idproyecto);
            $table->integer('com_upd_tsp');
        });

        return redirect('proyectos')->with('message', 'Se ha creado un nuevo proyecto');
    }

    public function ver($proyecto)
    {

        
        $proyecto=Proyecto::with('usuarios')->where('pro_id',$proyecto)->first();
        $plantas = \DB::table('Floor_'.$proyecto->pro_id)->orderBy('flo_id','DESC')->get();
        $pisos = \DB::table('Section_'.$proyecto->pro_id)->orderBy('sec_id','DESC')->get();
        $salas = \DB::table('Facility_'.$proyecto->pro_id)->orderBy('fac_id','DESC')->get();
        $comentarios = \DB::table('Comment_'.$proyecto->pro_id)->get();
        $documentos = \DB::table('Document_'.$proyecto->pro_id)->get();
        $usuarios = Usuario::orderBy('user_name', 'asc')->get();

        $categorias= \DB::table('Document_'.$proyecto->pro_id)->distinct()->orderBy('doc_metadata','ASC')->get(['doc_metadata']);


        $life=[];
        foreach ($categorias as $key ) {
            $json=json_decode($key->doc_metadata);
            $array=$json->estructura;
            $contador=count($array);
            $posicion=$contador-1;
            $life[]=array('id'=>md5($key->doc_metadata), 'nombre'=>$json->estructura[$posicion],'count'=>$contador, 'meta'=>$key->doc_metadata, 'idpadre'=>'');
        }


        usort($life, function($a,$b){ return $a['count']-$b['count'];} );
        $i=0;
        foreach ($life as $key ) {
            $count = $key['count'];

            if($count>1){

                $json=json_decode($key['meta']);
                $posicion=$count-1;
                $eliminar=',"'.$json->estructura[$posicion].'"';
                $padre = str_replace($eliminar,'',$key['meta']);

                $life[$i]['idpadre']=$padre;            

            }
            $i=$i+1;
        }


        return view('adminlte::proyectos.show', compact('proyecto', 'plantas', 'pisos', 'salas', 'comentarios', 'documentos', 'usuarios', 'categorias', 'life'));
    }

    public function SubirDocumentoProy(Request $request, $pro, $id ){

        $fecha=date("Y-m-d H:i:s");

        $documento=$request->file('documento');
        $cadena = \rand(100, 999);
        $documento->move('uploads', $cadena.$documento->getClientOriginalName());

        \DB::table('Document_'.$id)->insert([
            'doc_text'         => $request->descripcion,
            'doc_file_path'    => $cadena.$documento->getClientOriginalName(),
            'doc_name'         => $request->nombre,
            'doc_date'         => $fecha,
            'doc_type'         => 1,
            'doc_owner_id'     => 1,
            'doc_upd_tsp'      => \strtotime("now"),
            'doc_pro_id'       => $id
        ]);

        return redirect('proyectosver/'.$id)->with('messagedoc', 'Se ha agregado un nuevo documento al proyecto');


    }

    public function SubirDocumentoPlantas(Request $request, $pro, $id ){

        $fecha=date("Y-m-d H:i:s");

        $documento=$request->file('documento');
        $cadena = \rand(100, 999);
        $documento->move('uploads', $cadena.$documento->getClientOriginalName());

        \DB::table('Document_'.$id)->insert([
            'doc_text'         => $request->descripcion,
            'doc_file_path'    => $cadena.$documento->getClientOriginalName(),
            'doc_name'         => $request->nombre,
            'doc_date'         => $fecha,
            'doc_type'         => 1,
            'doc_owner_id'     => 1,
            'doc_upd_tsp'      => \strtotime("now"),
            'doc_flo_id'       => $id
        ]);

        return redirect('proyectosver/'.$id)->with('messagedoc', 'Se ha agregado un nuevo documento al proyecto');
    }

    public function SubirDocumentoPisos(Request $request, $pro, $id ){

        $fecha=date("Y-m-d H:i:s");

        $documento=$request->file('documento');
        $cadena = \rand(100, 999);
        $documento->move('uploads', $cadena.$documento->getClientOriginalName());

        \DB::table('Document_'.$id)->insert([
            'doc_text'         => $request->descripcion,
            'doc_file_path'    => $cadena.$documento->getClientOriginalName(),
            'doc_name'         => $request->nombre,
            'doc_date'         => $fecha,
            'doc_type'         => 1,
            'doc_owner_id'     => 1,
            'doc_upd_tsp'      => \strtotime("now"),
            'doc_sec_id'       => $id
        ]);

        return redirect('proyectosver/'.$id)->with('messagedoc', 'Se ha agregado un nuevo documento al proyecto');
    }

    public function SubirDocumentoSalas(Request $request, $pro, $id ){

        $fecha=date("Y-m-d H:i:s");

        $documento=$request->file('documento');
        $cadena = \rand(100, 999);
        $documento->move('uploads', $cadena.$documento->getClientOriginalName());

        \DB::table('Document_'.$id)->insert([
            'doc_text'         => $request->descripcion,
            'doc_file_path'    => $cadena.$documento->getClientOriginalName(),
            'doc_name'         => $request->nombre,
            'doc_date'         => $fecha,
            'doc_type'         => 1,
            'doc_owner_id'     => 1,
            'doc_upd_tsp'      => \strtotime("now"),
            'doc_fac_id'       => $id
        ]);

        return redirect('proyectosver/'.$id)->with('messagedoc', 'Se ha agregado un nuevo documento al proyecto');
    }

    public function agregarUsuario(Request $request, $id){

        $usuario=Usuario::where('user_email', $request->email)->first();
        if(isset($usuario->user_id)){

            $usuarioproyecto=Userproject::where('user_id',$usuario->user_id)
            ->where('proj_id',$id)->get();

            if($usuarioproyecto->count()==0){

                $proyecto=Proyecto::where('pro_id',$id)->first();

                $usuarioproy = new Userproject();
                $usuarioproy -> user_id = $usuario->user_id;
                $usuarioproy -> proj_id = $id;
                $usuarioproy -> user_type = 1;
                $usuarioproy -> user_act = 0;
                $usuarioproy -> save();

                $user= new Usuario(['nombre'=>$usuario->user_name, 'apellido'=>$usuario->user_last_name, 'email'=>$usuario->user_email, 'nombreproyecto'=>$proyecto->pro_name]);

                Mail::to($usuario->user_email)->send(new Welcome($user));

                return redirect('proyectosver/'.$id)->with('message1', 'Se ha agregado un nuevo usuario al proyecto');

            }else{

                return redirect('proyectosver/'.$id)->with('message2', 'El usuario ya se encuentra dentro del proycto');

            }


        }else{
            return redirect('proyectosver/'.$id)->with('message3', 'El email no existe dentro de los usuarios, contáctese con el administrador para agregarlo');
        };



    }


    public function CrearPlanta(Request $request, $proy){

        \DB::table('Floor_'.$proy)->insert([
            'flo_name'      => $request->nombreplanta,
            'flo_pro_id'    => $proy,
            'flo_upd_tsp'   => \strtotime("now"),
        ]);

        $plantanueva = \DB::table('Floor_'.$proy)->orderBy('flo_id','DESC')->first();

        return redirect('proyectosver/'.$proy.'#categorias')
        ->with('idplantanueva',$plantanueva->flo_id)
        ->with('plantanueva', 'Se ha agregado una nueva categoria al proyecto')
        ->with('mensaje','Categoria creada recientemente');

    }


    public function EditarPlanta(Request $request, $proy, $id){


        \DB::table('Floor_'.$proy)->where('flo_id',$id)->update([
            'flo_name'      => $request->nombreplanta,
        ]);

        $plantanueva = \DB::table('Floor_'.$proy)->where('flo_id',$id)->first();

        return redirect('proyectosver/'.$proy.'#categorias')
        ->with('idplantanueva',$plantanueva->flo_id)
        ->with('plantanueva', 'Se ha agregado una nueva categoria al proyecto')
        ->with('mensaje','Categoria editada recientemente');

    }

    public function CrearPiso(Request $request, $proy, $id){

        \DB::table('Section_'.$proy)->insert([
            'sec_name'      => $request->nombrepiso,
            'sec_flo_id'    => $id,
            'sec_upd_tsp'   => \strtotime("now"),
        ]);

        $pisonuevo = \DB::table('Section_'.$proy)->orderBy('sec_id','DESC')->first();



        return redirect('proyectosver/'.$proy.'#planta-'.$id)
        ->with('pisonuevo', 'Se ha agregado una nueva unidad a la categoria')
        ->with('planta',$id)
        ->with('idpisonuevo',$pisonuevo->sec_id)
        ->with('mensaje','Unidad creada recientemente');

    }


    public function EditarPiso(Request $request, $proy, $id){


        \DB::table('Section_'.$proy)->where('sec_id',$id)->update([
            'sec_name'      => $request->nombrepiso,
        ]);

        $pisonuevo = \DB::table('Section_'.$proy)->where('sec_id',$id)->first();

        return redirect('proyectosver/'.$proy.'#planta-'.$pisonuevo->sec_flo_id)
        ->with('pisonuevo', 'Se ha editado la unidad')
        ->with('planta',$pisonuevo->sec_flo_id)
        ->with('idpisonuevo',$pisonuevo->sec_id)
        ->with('mensaje','Unidad editada recientemente');

    }

    public function CrearSala(Request $request, $proy, $id){

        \DB::table('Facility_'.$proy)->insert([
            'fac_name'      => $request->nombresala,
            'fac_sec_id'    => $id,
            'fac_upd_tsp'   => \strtotime("now"),
        ]);

        $salanueva = \DB::table('Facility_'.$proy)->orderBy('fac_id','DESC')->first();

        $piso = \DB::table('Section_'.$proy)->where('sec_id',$id)->first();



        return redirect('proyectosver/'.$proy.'#piso-'.$id)
        ->with('salanueva', 'Se ha agregado una nueva sección al proyecto')
        ->with('idpiso', $piso->sec_flo_id)
        ->with('piso', $id)
        ->with('idsala', $salanueva->fac_id)
        ->with('mensaje','Recinto creado recientemente');
    }
        

    public function EditarSala(Request $request, $proy, $id){


        \DB::table('Facility_'.$proy)->where('fac_id',$id)->update([
            'fac_name'      => $request->nombresala,
        ]);

        $salanueva = \DB::table('Facility_'.$proy)->where('fac_id',$id)->first();



        $piso = \DB::table('Section_'.$proy)->where('sec_id',$salanueva->fac_sec_id)->first();


        return redirect('proyectosver/'.$proy.'#piso-'.$salanueva->fac_sec_id)
        ->with('salanueva', 'Se ha editado un recinto')
        ->with('idpiso', $piso->sec_flo_id)
        ->with('piso', $salanueva->fac_sec_id)
        ->with('idsala', $salanueva->fac_id)
        ->with('mensaje','Recinto editado recientemente');
    }



    public function EliminarUsuarioProject($userid, $projectid){
        Userproject::where('user_id', $userid)->where('proj_id', $projectid)->update(['user_act' => 0]);

        return redirect('proyectosver/'.$projectid)->with('message1', 'Se ha desactivado un usuario de este proyecto');
    }


    public function ActivarUsuarioProject($userid, $projectid){
        Userproject::where('user_id', $userid)->where('proj_id', $projectid)->update(['user_act' => 1]);

        return redirect('proyectosver/'.$projectid)->with('message1', 'Se ha activado un usuario de este proyecto');
    }


    public function CopiarPlanta($idproyecto, $idplanta){

        $planta = \DB::table('Floor_'.$idproyecto)->where('flo_id',$idplanta)->first();

        \DB::table('Floor_'.$idproyecto)->insert([
            'flo_name'      => $planta->flo_name.'_copia',
            'flo_pro_id'    => $idproyecto,
            'flo_upd_tsp'   => \strtotime("now"),
        ]);

        $newplanta = \DB::table('Floor_'.$idproyecto)->orderBy('flo_id','DESC')->first();
        $idplantanueva=$newplanta->flo_id;

        $secciones = \DB::table('Section_'.$idproyecto)->where('sec_flo_id',$idplanta)->get();

        foreach ($secciones as $key) {


            \DB::table('Section_'.$idproyecto)->insert([
                'sec_name'      => $key->sec_name,
                'sec_flo_id'    => $idplantanueva,
                'sec_upd_tsp'   => \strtotime("now"),
            ]);

            $newseccion = \DB::table('Section_'.$idproyecto)->orderBy('sec_id','DESC')->first();
            $idseccionnueva = $newseccion->sec_id;

            $salas = \DB::table('Facility_'.$idproyecto)->where('fac_sec_id',$key->sec_id)->get();

            foreach ($salas as $key ) {

                \DB::table('Facility_'.$idproyecto)->insert([
                    'fac_name'      => $key->fac_name,
                    'fac_sec_id'    => $idseccionnueva,
                    'fac_upd_tsp'   => \strtotime("now"),
                ]);

            }



        }

        return redirect('proyectosver/'.$idproyecto)->with('messagedoc', 'Se ha duplicado la planta '.$planta->flo_name);

        return redirect('proyectosver/'.$proy.'#categorias')
        ->with('idplantanueva',$idplantanueva)
        ->with('plantanueva', 'Se ha agregado una nueva categoria al proyecto');

    }



    public function CopiarPiso($idproyecto, $idpiso){

        $piso = \DB::table('Section_'.$idproyecto)->where('sec_id',$idpiso)->first();

        \DB::table('Section_'.$idproyecto)->insert([
            'sec_name'      => $piso->sec_name.'_copia',
            'sec_flo_id'    => $piso->sec_flo_id,
            'sec_upd_tsp'   => \strtotime("now"),
        ]);

        $newpiso = \DB::table('Section_'.$idproyecto)->orderBy('sec_id','DESC')->first();
        $idpisonuevo=$newpiso->sec_id;

        $salas = \DB::table('Facility_'.$idproyecto)->where('fac_sec_id',$idpiso)->get();

        foreach ($salas as $key) {

            \DB::table('Facility_'.$idproyecto)->insert([
                'fac_name'      => $key->fac_name,
                'fac_sec_id'    => $idpisonuevo,
                'fac_upd_tsp'   => \strtotime("now"),
            ]);

        }

        return redirect('proyectosver/'.$idproyecto.'#planta-'.$piso->sec_flo_id)
        ->with('pisonuevo', 'Se ha agregado una nueva unidad a la categoria')
        ->with('planta',$piso->sec_flo_id)
        ->with('idpisonuevo',$newpiso->sec_id);

    }


    public function Copiarsala($idproyecto, $idsala){

        $sala = \DB::table('Facility_'.$idproyecto)->where('fac_id',$idsala)->first();

        \DB::table('Facility_'.$idproyecto)->insert([
            'fac_name'      => $sala->fac_name.'_copia',
            'fac_sec_id'    => $sala->fac_sec_id,
            'fac_upd_tsp'   => \strtotime("now"),
        ]);

        $salanueva = \DB::table('Facility_'.$idproyecto)->orderBy('fac_id','DESC')->first();

        $piso = \DB::table('Section_'.$idproyecto)->where('sec_id',$salanueva->fac_sec_id)->first();

        return redirect('proyectosver/'.$idproyecto.'#piso-'.$sala->fac_sec_id)
        ->with('salanueva', 'Se ha agregado una nueva sección al proyecto')
        ->with('idpiso', $piso->sec_flo_id)
        ->with('piso', $sala->fac_sec_id)
        ->with('idsala', $salanueva->fac_id);

    }



    public function EliminarPlanta($idproyecto, $idplanta){

        \DB::table('Delete_'.$idproyecto)->insert([
            'del_flo_id'      => $idplanta,
            'del_TIMESTAMP'   => \strtotime("now"),
        ]);

        \DB::table('Floor_'.$idproyecto)->where('flo_id',$idplanta)->delete();


        $secciones = \DB::table('Section_'.$idproyecto)->where('sec_flo_id',$idplanta)->get();

        foreach ($secciones as $key) {

            \DB::table('Delete_'.$idproyecto)->insert([
                'del_sec_id'      => $key->sec_id,
                'del_TIMESTAMP'   => \strtotime("now"),
            ]);
        }

        return redirect('proyectosver/'.$idproyecto.'#categorias')
        ->with('messageplanta', 'Se ha eliminado la planta')
        ->with('plantaeliminada', 'Se ha eliminado la planta');

    }

    public function EliminarPiso($idproyecto, $idpiso){

        $piso = \DB::table('Section_'.$idproyecto)->where('sec_id',$idpiso)->first();


        \DB::table('Delete_'.$idproyecto)->insert([
            'del_sec_id'      => $idpiso,
            'del_TIMESTAMP'   => \strtotime("now"),
        ]);

        \DB::table('Section_'.$idproyecto)->where('sec_id',$idpiso)->delete();

        return redirect('proyectosver/'.$idproyecto.'#planta-'.$piso->sec_flo_id)
        ->with('pisonuevo', 'Se ha eliminado una unidad')
        ->with('planta',$piso->sec_flo_id);

    }

    public function subirdoc(Request $request)
    {

        if($request->categoria==""){
            $this->validate(request(),[
                'descripcion'       =>  'required|string',
                'nombre'            =>  'required|string',
                'nombre_imagen'     =>  'required|string',
                'nueva_categoria'   =>   'required|string',
            ]);
        }else{
            $this->validate(request(),[
                'descripcion'   =>  'required|string',
                'nombre'        =>  'required|string',
                'nombre_imagen' =>  'required|string',
                'categoria'     =>  'required|string',
            ]);
        }


//categoria
        if($request->categoria==""){
            if($request->categoria_padre==""){
                $categoria='{"estructura": ["'.$request->nueva_categoria.'"]}';

            }else{

                $borrar= array(']}');
                $padre = str_replace($borrar, '',$request->categoria_padre);
                $categoria=$padre.',"'.$request->nueva_categoria.'"]}';
            }
        }else{

            $categoria=$request->categoria;
        }



        if($request->desde=="proyecto"){
            $desde="proyecto";

            $fecha=date("Y-m-d H:i:s");

            \DB::table('Document_'.$request->idproyecto)->insert([
                'doc_text'         => $request->descripcion,
                'doc_file_path'    => $request->nombre_imagen,
                'doc_name'         => $request->nombre,
                'doc_date'         => $fecha,
                'doc_type'         => 1,
                'doc_owner_id'     => Auth::user()->user_id,
                'doc_upd_tsp'      => \strtotime("now"),
                'doc_pro_id'       => $request->idproyecto,
                'doc_metadata'     => $categoria,
            ]);

            $idenviada = $request->idproyecto;

        }

        if($request->desde=="planta"){
            $desde="planta";

            $fecha=date("Y-m-d H:i:s");

            \DB::table('Document_'.$request->idproyecto)->insert([
                'doc_text'         => $request->descripcion,
                'doc_file_path'    => $request->nombre_imagen,
                'doc_name'         => $request->nombre,
                'doc_date'         => $fecha,
                'doc_type'         => 1,
                'doc_owner_id'     => Auth::user()->user_id,
                'doc_upd_tsp'      => \strtotime("now"),
                'doc_flo_id'       => $request->idplanta,
                'doc_metadata'     => $categoria,
            ]);

            $idenviada = $request->idplanta;

        }

        if($request->desde=="piso"){
            $desde="piso";

            $fecha=date("Y-m-d H:i:s");

            \DB::table('Document_'.$request->idproyecto)->insert([
                'doc_text'         => $request->descripcion,
                'doc_file_path'    => $request->nombre_imagen,
                'doc_name'         => $request->nombre,
                'doc_date'         => $fecha,
                'doc_type'         => 1,
                'doc_owner_id'     => Auth::user()->user_id,
                'doc_upd_tsp'      => \strtotime("now"),
                'doc_sec_id'       => $request->idpiso,
                'doc_metadata'     => $categoria,
            ]);

            $idenviada = $request->idpiso;
        }

        if($request->desde=="sala"){
            $desde="sala";

            $fecha=date("Y-m-d H:i:s");

            \DB::table('Document_'.$request->idproyecto)->insert([
                'doc_text'         => $request->descripcion,
                'doc_file_path'    => $request->nombre_imagen,
                'doc_name'         => $request->nombre,
                'doc_date'         => $fecha,
                'doc_type'         => 1,
                'doc_owner_id'     => Auth::user()->user_id,
                'doc_upd_tsp'      => \strtotime("now"),
                'doc_fac_id'       => $request->idsala,
                'doc_metadata'     => $categoria,
            ]);

            $idenviada = $request->idsala;
        }
        return response()->json(['message' => $categoria, 'desde' =>$desde, 'id'=>$idenviada]);

    }

}
