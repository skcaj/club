<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['guest']],function(){ /// Middleware de  Invitados  sin auntenticar
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('entrar');
    Route::get('/','Auth\LoginController@showLoginForm')->name('login');
});

Route::group(['middleware'=>['auth']],function(){ /// Middleware de Rutas con  Usuario Autenticados

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');
    

    Route::group(['middleware'=>['Administrador']],function(){

     });

    Route::group(['middleware'=>['Director']],function(){ 

    });

    Route::group(['middleware'=>['Consejero']],function(){ 

    });

    Route::group(['middleware'=>['Conquistador']],function(){

     });


    Route::get('/unidad', 'UnidadController@index');
    Route::get('/unidad/activa', 'UnidadController@activa');
    Route::post('/unidad/registrar', 'UnidadController@store');
    Route::put('/unidad/actualizar', 'UnidadController@update');
    Route::put('/unidad/desactivar', 'UnidadController@desactivar');
    Route::put('/unidad/activar', 'UnidadController@activar');
    
    Route::get('/conquistador', 'ConquistadorController@index');
    Route::post('/conquistador/registrar', 'ConquistadorController@store');
    Route::put('/conquistador/actualizar', 'ConquistadorController@update');
    Route::put('/conquistador/desactivar', 'ConquistadorController@desactivar');
    Route::put('/conquistador/activar', 'ConquistadorController@activar');
    Route::get('/conquistador/selectConquistador', 'ConquistadorController@selectConquistador');
    Route::get('/conquistador/selectConquistadorUnidad', 'ConquistadorController@selectConquistadorUnidad');
    Route::get('/conquistador/buscarConquistador', 'ConquistadorController@buscarConquistador');
    Route::get('/conquistador/listarPdf', 'ConquistadorController@listarPdf')->name('conquistadores_pdf');

    
    Route::get('/tipopagos', 'TipoPagoController@index');
    Route::post('/tipopagos/registrar', 'TipoPagoController@store');
    Route::get('/tipopagos/activa', 'TipoPagoController@activa');
    Route::put('/tipopagos/actualizar', 'TipoPagoController@update');
    Route::put('/tipopagos/desactivar', 'TipoPagoController@desactivar');
    Route::put('/tipopagos/activar', 'TipoPagoController@activar');
    
    Route::get('/pagos', 'PagoController@index');
    Route::post('/pagos/registrar', 'PagoController@store');
    Route::put('/pagos/actualizar', 'PagoController@update');
    Route::put('/pagos/desactivar', 'PagoController@desactivar');
    Route::put('/pagos/activar', 'PagoController@activar');
    Route::get('/pagos/filtrar', 'PagoController@filtrar');
    
    Route::get('/rol', 'RolController@index');
    Route::put('/rol/desactivar', 'RolController@desactivar');
    Route::put('/rol/activar', 'RolController@activar');
    Route::get('/rol/activa', 'RolController@activa');
    
    Route::get('/user', 'UserController@index');
    Route::post('/user/registrar', 'UserController@store');
    Route::put('/user/actualizar', 'UserController@update');
    Route::put('/user/desactivar', 'UserController@desactivar');
    Route::put('/user/activar', 'UserController@activar');
    Route::put('/user/delete', 'UserController@delete');

    Route::get('/asistencia', 'asistenciaController@index');
    Route::post('/asistencia/registrar', 'asistenciaController@store');
    Route::get('/asistencia/obtenerCabecera', 'asistenciaController@obtenerCabecera');
    Route::get('/asistencia/obtenerDetalles', 'asistenciaController@obtenerDetalles');
    Route::put('/asistencia/delete', 'asistenciaController@delete');
    Route::put('/asistencia/actualizar', 'asistenciaController@update');
    Route::get('/asistencia/pdf/{id}', 'asistenciaController@asisPdf')->name('asistencia_pdf');
    
    

});



Route::get('/home', 'HomeController@index')->name('home');

