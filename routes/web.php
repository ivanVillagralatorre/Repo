<?php

use App\Models\Roles;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\PagUsuario;
use App\Http\Controllers\PagTecnico;
use App\Models\tablaEstructuras;
use App\Models\tablaTiposObra;

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

//Route::view('/','welcome')->name('welcome');


Route::get('login','App\Http\Controllers\Logincontroller@index')->name('login');

Route::post('login','App\Http\Controllers\Logincontroller@login')->name('logged');

Route::get('/emailtestform', function () {
    $botonNav = "INICIAR SESION";
    $dato = "black";
    return view('emailtest',compact('dato'))->with('botonNav',$botonNav);
})->name('emailtestform'); //Esta ruta la ponemos en la raiz para que nada mas ejecutar nuestra aplicación aparezca nuestro formulario

Route::post('/contactar', 'App\Http\Controllers\EmailController@contact')->name('contact');//Ruta que esta señalando nuestro formulario

Route::post('usuario', 'App\Http\Controllers\PagUsuario@solicitarObra')->name('usuario.solicitarObra');

Route::get('/', function () {
    $botonNav = "INICIAR SESION";
    return view('principal')->with('botonNav',$botonNav);
});

Route::get('/usuario', 'App\Http\Controllers\PagUsuario@entrar');

Route::get('/tecnico', function (){
    session_start();
    if (!isset($_SESSION["user"])){
        return redirect("login");
    }
    $obrasSolicitadas = app(PagTecnico::class)->extraerObras(1);
    $obrasAceptadas = app(PagTecnico::class)->extraerObras(2);
    $botonNav = "CERRAR SESION";
    return view("tecnico")->with('botonNav', $botonNav)->with("obrasSolicitadas",$obrasSolicitadas)->with("obrasAceptadas",$obrasAceptadas);
});

Route::get('/public/{archivo}', function ($archivo){
    return Storage::download("planos/".$archivo);
});

Route::get('/tecnico/{estado}/{id}', 'App\Http\Controllers\PagTecnico@cambiarEstado');

Route::get('/tecnico/obra/aceptar/{id}', 'App\Http\Controllers\PagTecnico@aceptarObra');

Route::get('/tecnico/obra/denegar/{id}', 'App\Http\Controllers\PagTecnico@denegarObra');

Route::view('/registro','registro')->name('registro');

Route::post('registro','App\Http\Controllers\RegistroController@store');

Route::get('reset','App\Http\Controllers\ResetController@index')->name('reset');

Route::patch('reset','App\Http\Controllers\ResetController@update')->name('reseteo');

Route::get('confimacion',function (){
    $botonNav = "INICIAR SESION";
    return view('confirmacion')->with('botonNav',$botonNav);
})->name('confirmacion');
