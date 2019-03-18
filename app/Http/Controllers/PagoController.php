<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function index(Request $request)    {
       if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX


     
      $pagos= Pago::with('conquistador')->with('tpagos')->with('User')->orderBy('id','desc')->paginate(1000);
        
       $saldo= Pago::select('monto')->orderBy('id','asc')->paginate(3);

       
        return [
            'pagination' => [
                'total'        => $pagos->total(),
                'current_page' => $pagos->currentPage(),
                'per_page'     => $pagos->perPage(),
                'last_page'    => $pagos->lastPage(),
                'from'         => $pagos->firstItem(),
                'to'           => $pagos->lastItem(),
            ],
            //'saldo'=>$saldo,
            'pagos' =>$pagos
        ];
    }
    public function filtrar(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX
 
           
         $buscar = $request->buscar;
         $criterio= $request->criterio;
         $id=$request->id;
         $fechaA=$request->fechaA;
         $fechaB=$request->fechaB;
        // $miFecha= new Date($fechaA);
        
        

         if($fechaA=='' && $fechaB==''){
 
            if ($criterio=='' || $id==0) {
                $pagos= Pago::with('conquistador')->with('tpagos')->with('User')->orderBy('id','asc')->paginate(10);
            }else if($criterio!='' && $id!=0){          
            $pagos=   Pago::with('conquistador')->with('tpagos')->with('User')->where($criterio,'=',$id)->orderBy('id','desc')->paginate(10);
            } 
         }else if($fechaA!=''){
            $pagos= Pago::with('conquistador')->with('tpagos')->with('User')->whereDate('created_at','like','%'.$fechaA.'%')->orderBy('id','asc')->paginate(10);
         }

         return [
             'pagination' => [
                 'total'        => $pagos->total(),
                 'current_page' => $pagos->currentPage(),
                 'per_page'     => $pagos->perPage(),
                 'last_page'    => $pagos->lastPage(),
                 'from'         => $pagos->firstItem(),
                 'to'           => $pagos->lastItem(),
             ],
             'pagos' => $pagos
         ];
         
     }
 
    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $pagos = new Pago();
        $pagos->id_conquistador = $request->id_conquistador;
        $pagos->monto = $request->monto;
        $pagos->id_pagos = $request->id_pagos;
        $pagos->id_usuario = '1';
        $pagos->ie =$request->ie;
        $pagos->descripcion =$request->descripcion;
        $pagos->id_unidad =$request->id_unidad;
        $pagos->condicion = '1';
        $pagos->save();
    }
    public function update(Request $request) {  
        
        if (!$request->ajax()) return redirect('/');
        $pagos = Pago::findOrFail($request->id);
        $pagos->monto = $request->monto;
        $pagos->id_pagos = $request->id_pagos;
        $pagos->id_usuario = '1';
        $pagos->ie =$request->ie;
        $pagos->descripcion =$request->descripcion;
        $pagos->condicion = '1';
        $pagos->save();
    }
    public function desactivar(Request $request){
        if(!$request->ajax())return redirect('/');
        $pagos= Pago::findOrFail($request->id);
        $pagos->condicion = '0';
        $pagos->save();

    }
    public function activar(Request $request){
        if(!$request->ajax())return redirect('/');
        $pagos= Pago::findOrFail($request->id);
        $pagos->condicion = '1';
        $pagos->save();

    }
    
}
