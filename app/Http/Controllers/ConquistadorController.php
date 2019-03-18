<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  /// importante para  Identificar Usuarios Autenticados
use App\Conquistador;

class ConquistadorController extends Controller
{

    
    public function index(Request $request)    {
        if(!$request->ajax())return redirect('/'); // Para  Evitar Peticiones que no sean mediante AJAX

          
        $buscar = $request->buscar;
        $criterio= $request->criterio;
        $usuario = Auth::user();
        $unidad=$usuario->unidad_cargo;
        if ($buscar==''&& $usuario->id_rol!=3) {
            $conquistadores= Conquistador::with('Unidad')->orderBy('nombres','asc')->paginate(10);
        }elseif($usuario->id_rol==3)
        $conquistadores=  Conquistador::with('Unidad')->where($criterio,'like','%'.$buscar.'%')->where('unidad','=',$unidad)->orderBy('nombres','asc')->paginate(10);
        else{

          $conquistadores=  Conquistador::with('Unidad')->where($criterio,'like','%'.$buscar.'%')->orderBy('nombres','asc')->paginate(10);
        }

        
        return [
            'pagination' => [
                'total'        => $conquistadores->total(),
                'current_page' => $conquistadores->currentPage(),
                'per_page'     => $conquistadores->perPage(),
                'last_page'    => $conquistadores->lastPage(),
                'from'         => $conquistadores->firstItem(),
                'to'           => $conquistadores->lastItem(),
            ],
            'usuario' => $usuario->id_rol,
            'conquistadores' => $conquistadores
        ];
    }
    public function selectConquistador(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;

        $conquistadores = Conquistador::where('nombres','like','%'.$filtro.'%')->where('condicion','=',1)->orderBy('id','asc')->get();
 
        return ['conquistadores' => $conquistadores];
    }

    public function selectConquistadorUnidad(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $usuario = Auth::user();
        $unidad=$usuario->unidad_cargo;

        $conquistadores = Conquistador::where('nombres','like','%'.$filtro.'%')->where('condicion','=',1)->where('unidad','=',$unidad)->orderBy('id','asc')->get();
 
        return ['conquistadores' => $conquistadores];
    }

    public function store(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $usuario = Auth::user();

        $conquistador = new Conquistador();
        $conquistador->identidad = $request->identidad;
        $conquistador->nombres = $request->nombres;
        $conquistador->apellidos = $request->apellidos;
        if($request->unidad!=0)
        $conquistador->unidad = $request->unidad;
        else
        $conquistador->unidad = $usuario->unidad_cargo;;
        $conquistador->imagenurl ='imagen.jpg';
        $conquistador->condicion = '1';
        $conquistador->save();
    }

    public function update(Request $request) {  
        
        if (!$request->ajax()) return redirect('/');
        $conquistador = Conquistador::findOrFail($request->id);
        $conquistador->identidad = $request->identidad;
        $conquistador->nombres = $request->nombres;
        $conquistador->apellidos = $request->apellidos;
        $conquistador->unidad = $request->unidad;
        $conquistador->imagenurl ='imagen.jpg';
        $conquistador->condicion = '1';
        $conquistador->save();
    
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $conquistador= Conquistador::findOrFail($request->id);
        $conquistador->condicion = '0';
        $conquistador->save();

    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $conquistador= Conquistador::findOrFail($request->id);
        $conquistador->condicion = '1';
        $conquistador->save();

    }
    public function buscarConquistador(Request $request){
        if (!$request->ajax()) return redirect('/');
        $usuario = Auth::user();
        $unidad=$usuario->unidad_cargo;

        $filtro = $request->filtro;
        if($usuario->id_rol==3)
        $conquistador = Conquistador::where('identidad','=', $filtro)->where('unidad','=',$unidad)->orderBy('nombres', 'asc')->take(1)->get();
        else
        $conquistador = Conquistador::where('identidad','=', $filtro)->orderBy('nombres', 'asc')->take(1)->get();
        return ['conquistador' => $conquistador];
    }
    public function listarPdf(){

        $conquistadores= Conquistador::with('Unidad')->orderBy('nombres','asc')->get();

        $cont=Conquistador::count();

        $pdf = \PDF::loadView('pdf.conquistadorespdf',['conquistadores'=>$conquistadores,'cont'=>$cont])->setPaper('a4', 'portrait');
        return $pdf->stream('conquistadores.pdf');
    }
}
