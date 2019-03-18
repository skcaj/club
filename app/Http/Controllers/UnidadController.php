<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;

class UnidadController extends Controller
{
    public function index(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX

            $unidades= Unidad::orderBy('nombreunidad','asc')->get();
                return [
                    'unidades' => $unidades
                ];
    }

    public function activa(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX

            $unidades= Unidad::where('condicion','=',1)->orderBy('nombreunidad','asc')->get();
                return [
                    'unidades' => $unidades
                ];
    }

  
    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $unidades=new Unidad();
        $unidades->nombreunidad = $request->nombreunidad;
        $unidades->descripcion = $request->descripcion;
        $unidades->condicion = '1';
        $unidades->save();

    }
    


  
    public function update(Request $request) // solo dejamos con el reques no con iD
    {  
        if(!$request->ajax())return redirect('/');
        $unidades= Unidad::findOrFail($request->id);
        $unidades->nombreunidad = $request->nombreunidad;
        $unidades->descripcion = $request->descripcion;
        $unidades->condicion = '1';
        $unidades->save();
    }

    
    public function desactivar(Request $request){
        if(!$request->ajax())return redirect('/');
        $unidades= Unidad::findOrFail($request->id);
        $unidades->condicion = '0';
        $unidades->save();

    }
    public function activar(Request $request){
        if(!$request->ajax())return redirect('/');
        $unidades= Unidad::findOrFail($request->id);
        $unidades->condicion = '1';
        $unidades->save();

    }

}
