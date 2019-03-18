<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)    {
        if(!$request->ajax())return redirect('/'); 

            $roles= rol::orderBy('id','asc')->get();
                return [
                    'roles' => $roles
                ];
    }

    public function activa(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX

            $roles= rol::where('condicion','=',1)->orderBy('id','asc')->get();
                return [
                    'roles' => $roles
                ];
    } 
    public function desactivar(Request $request){
        if(!$request->ajax())return redirect('/');
        $roles= rol::findOrFail($request->id);
        $roles->condicion = '0';
        $roles->save();

    }
    public function activar(Request $request){
        if(!$request->ajax())return redirect('/');
        $roles= rol::findOrFail($request->id);
        $roles->condicion = '1';
        $roles->save();

    }

}
