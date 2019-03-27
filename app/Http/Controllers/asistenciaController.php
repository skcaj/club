<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistencia;
use App\Detalle_asistencia;
use Illuminate\Support\Facades\Auth;  /// importante para  Identificar Usuarios Autenticados
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class asistenciaController extends Controller
{
    public function index(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX
 
        $criterio= $request->criterio;
        $usuario = Auth::user();
        $unidad=$usuario->unidad_cargo;
        $buscar = $request->buscar;
      
        if ($usuario->id_rol!=3 &&$criterio=='') {
             $asistencias= asistencia::with('unidad')->with('User')->orderBy('id','desc')->paginate(10);
        }else if ($usuario->id_rol!=3 &&$criterio!='') {
            $asistencias= asistencia::with('unidad')->with('User')->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
       }else{
             $asistencias= asistencia::with('unidad')->with('User')->where('id_unidad','=',$unidad)->orderBy('id','desc')->paginate(10);
        }
         
         
         return [
             'pagination' => [
                 'total'        => $asistencias->total(),
                 'current_page' => $asistencias->currentPage(),
                 'per_page'     => $asistencias->perPage(),
                 'last_page'    => $asistencias->lastPage(),
                 'from'         => $asistencias->firstItem(),
                 'to'           => $asistencias->lastItem(),
             ],
             'admin'=>$usuario->id_rol,
             'asistencias' =>$asistencias
         ];
        }


    
    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

           
            $usuario = Auth::user();
            $unidad=$usuario->unidad_cargo;
            $id=$usuario->id;

            $asistencias = new asistencia();
            if($usuario->id_rol==3)
            $asistencias->id_unidad = $unidad;
            else
            $asistencias->id_unidad = $request->id_unidad;
            $asistencias->id_usuario = $id;
          
            $asistencias->total = $request->total;
           
            $asistencias->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new detalle_asistencia();
                $detalle->id_asistencia = $asistencias->id;
                $detalle->id_conquistador = $det['idconquistador'];
                $detalle->cuota = $det['cuota'];
                $detalle->puntualidad = $det['puntualidad'];
                $detalle->uniforme = $det['uniforme'];
                $detalle->material = $det['material'];
                $detalle->p_cuota = $det['p_cuota'];
                $detalle->t_puntos = $det['t_puntos'];
                $detalle->s_cuota = $det['s_cuota'];

              

                      
                $detalle->save();
            }       
            DB::commit();
            
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $asis= asistencia::with('unidad')->with('User')->where('id','=',$id)->orderBy('id','desc')->take(1)->get();
        
        return ['asis' => $asis];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = detalle_asistencia::with('unidad')->with('conquistador')->where('id_asistencia','=',$id)->get();
        
        return ['detalles' => $detalles];
    }

    /*public function delete(Request $request){
        if(!$request->ajax())return redirect('/');

        $detalle = detalle_asistencia::findOrFail($request->id_asistencia);
        $detalle->delete();

        $asistencias= asistencia::findOrFail($request->id);
        $asistencias->delete();

    }*/

    public function update(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $asistencia = asistencia::findOrFail($request->id);
        $asistencia->total = $request->total;
        $asistencia->save();
 
            try{
                DB::beginTransaction();
                $detalles = $request->data;

                foreach($detalles as $ep=>$det){
                    $detalle =  detalle_asistencia::findOrFail($det['id']);
                    $detalle->cuota = $det['cuota'];
                          
                    $detalle->save();
                }  
               
    
                    
                DB::commit();
                
            } catch (Exception $e){
                DB::rollBack();
            }
        
    }
    public function asisPdf(Request $request,$id){


       
        $asis= asistencia::with('unidad')->with('User')->where('id','=',$id)->orderBy('id','desc')->take(1)->get();
        
        $detalles = detalle_asistencia::with('unidad')->with('conquistador')->where('id_asistencia','=',$id)->get();
        
       

        $pdf = \PDF::loadView('pdf.cuota',['detalles'=>$detalles,'asis'=>$asis])->setPaper('a4', 'portrait');
        return $pdf->stream('cuota.pdf');
    }
    
}
