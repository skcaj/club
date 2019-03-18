<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;  /// importante para  Identificar Usuarios Autenticados
use App\User;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)    {
      if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX

          
        $buscar = $request->buscar;
        $criterio= $request->criterio;
        $usuario = Auth::user();
        $unidad=$usuario->unidad_cargo;

        if ($buscar==''&&$usuario->id_rol!=3) {
            $users= User::with('conquistador')->with('unidad')->with('roles')->orderBy('usuario','asc')->paginate(10);
        }else if( $usuario->id_rol==3){
            $users= User::with('conquistador')->with('unidad')->with('roles')->where('unidad_cargo','=',$unidad)->where('id_rol','=',4)->orderBy('usuario','asc')->paginate(10);
        }else{
            $users= User::with('conquistador')->with('unidad')->with('roles')->where($criterio,'like','%'.$buscar.'%')->orderBy('usuario','asc')->paginate(10);
        }

        
        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'usuario' => $usuario->id_rol,
            'users' => $users
        ];
    }
    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $users = new User();
        $users->usuario = $request->usuario;
        $users->password = bcrypt( $request->password);
        $users->id_conquistador = $request->id_conquistador;
        $users->id_rol = $request->id_rol;
        $users->condicion = '1';
        $users->unidad_cargo = $request->unidad_cargo;
        $users->save();
    }

    public function update(Request $request) {  
        
        if (!$request->ajax()) return redirect('/');
        $users = User::findOrFail($request->id);
        $users->usuario = $request->usuario;
        if($request->password!=''){
        $users->password =bcrypt( $request->password);
        }
        $users->id_rol = $request->id_rol;
        $users->condicion = '1';
        $users->unidad_cargo = $request->unidad_cargo;
        $users->save();
    }

    public function desactivar(Request $request){
        if(!$request->ajax())return redirect('/');
        $users= User::findOrFail($request->id);
        $users->condicion = '0';
        $users->save();

    }
    public function activar(Request $request){
        if(!$request->ajax())return redirect('/');
        $users= User::findOrFail($request->id);
        $users->condicion = '1';
        $users->save();

    }
    public function delete(Request $request){
        if(!$request->ajax())return redirect('/');
        $users= User::findOrFail($request->id);
        $users->delete();

    }
    
}
