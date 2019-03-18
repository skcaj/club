<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo_pago;

class TipoPagoController extends Controller
{
    public function index(Request $request)    {
        if(!$request->ajax())return redirect('/'); 

            $tipos_pagos= tipo_pago::orderBy('nombrepagos','asc')->get();
                return [
                    'tipos_pagos' => $tipos_pagos
                ];
    }

    public function activa(Request $request)    {
        if(!$request->ajax())return redirect('/'); 

            $tipos_pagos= tipo_pago::where('condicion','=',1)->orderBy('nombrepagos','asc')->get();
                return [
                    'tipos_pagos' => $tipos_pagos
                ];
    }

  
    public function store(Request $request)   {
        if(!$request->ajax())return redirect('/');
        $tipos_pagos=new tipo_pago();
        $tipos_pagos->nombrepagos = $request->nombrepagos;
        $tipos_pagos->descripcion = $request->descripcion;
        $tipos_pagos->condicion = '1';
        $tipos_pagos->save();

    }
    


  
    public function update(Request $request) // solo dejamos con el reques no con iD
    {  
        if(!$request->ajax())return redirect('/');
        $tipos_pagos= tipo_pago::findOrFail($request->id);
        $tipos_pagos->nombrepagos = $request->nombrepagos;
        $tipos_pagos->descripcion = $request->descripcion;
        $tipos_pagos->condicion = '1';
        $tipos_pagos->save();
    }

    
    public function desactivar(Request $request){
        if(!$request->ajax())return redirect('/');
        $tipos_pagos= tipo_pago::findOrFail($request->id);
        $tipos_pagos->condicion = '0';
        $tipos_pagos->save();

    }
    public function activar(Request $request){
        if(!$request->ajax())return redirect('/');
        $tipos_pagos= tipo_pago::findOrFail($request->id);
        $tipos_pagos->condicion = '1';
        $tipos_pagos->save();

    }
}
