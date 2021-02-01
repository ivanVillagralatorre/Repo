<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Direcciones;
use App\Models\tablaEstados;
use App\Models\tablaEstructuras;
use App\Models\tablaObras;
use App\Models\tablaTiposObra;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

class PagUsuario extends Controller
{

    public function entrar(){
        session_start();
        if (!isset($_SESSION["user"])){
            return redirect("login");
        }
        $obras = $this->extraerObras();
        $botonNav = "CERRAR SESION";
        $tiposObra = tablaTiposObra::get();
        $tiposEstructura = tablaEstructuras::get();
        return view("usuario")->with('botonNav', $botonNav)->with('tiposObra', $tiposObra)->with('tiposEstructura', $tiposEstructura)->with("obras",$obras);
    }

    public function solicitarObra(){
        session_start();

        //APARTADO DE LA DIRECCION DE LA OBRA

        $calle = request('calle');
        $portal = request('portal');
        $piso = request('piso');


        $IDdireccion = $this->comprobarExistenciaDireccion($calle,$portal,$piso);
        $nuevaDireccion = "";
        if($IDdireccion==-1){
            $codpostal = request('codpostal');
            $latitud = request('latitud');
            $longitud = request('longitud');
           $nuevaDireccion = $this->insertarNuevaDireccion($calle,$portal,$piso,$longitud,$latitud,$codpostal);
            $IDdireccion = $nuevaDireccion->id;
        }

        //APARTADO DEL TIPO DE ESTRUCTURA , OBRA Y DESCRIPCION

        $estructura = request('estructura');
        $obra = request('obra');
        $descripcion = request('descripcion');
        $estado = 1;



        //APARTADO DEL SOLICITANTE

        $dniSolicitante = $_SESSION["user"]["id"];


        //INSERTAR OBRA

        $createObra = tablaObras::create([
            'tipo_estructura' => $estructura,
            'tipo_obra' => $obra,
            'direccion' => $IDdireccion,
            'descripcion' => $descripcion,
            'estado' => $estado,
            'solicitante' => $dniSolicitante
        ]);

        //APARTADO DEL ARCHIVO ADJUNTO

        $request = \request();
        $archivo2 = $request->file('archivo');
        $nombreArchivo = $createObra->id;
        if ($archivo2 != ""){
            $archivo2->storeAs('planos',$nombreArchivo.'.'.$request->file('archivo')->extension());
            $url = $nombreArchivo.'.'.$request->file("archivo")->extension();
            $this->updateArchivoPlanoObra($url,$nombreArchivo);
        }

        return back();

    }

    public function comprobarExistenciaDireccion($calle,$portal,$piso){
        $bdDireccion = Direcciones::get()->where('calle',$calle)->where('numero',$portal)->where('piso',$piso)->first();
        if (empty($bdDireccion)){
            return -1;
        }else{
            return $bdDireccion->id;
        }
    }

    public function insertarNuevaDireccion($calle,$portal,$piso,$longitud,$latitud,$codpostal){
        $nuevaDireccion = Direcciones::create([
            'calle' => $calle,
            'numero' => $portal,
            'piso' => $piso,
            'cod_postal' => $codpostal,
            'latitud' => $latitud,
            'longitud' => $longitud
        ]);
        return $nuevaDireccion;
    }

    public function updateArchivoPlanoObra($archivo,$idObra){
        $obra = tablaObras::find($idObra);
        $obra->plano = $archivo;
        $obra->save();
    }

    public function extraerObras(){

        $dni = $_SESSION["user"]["id"];
        $obrasBBDD = tablaObras::where('solicitante',$dni)->paginate(5);


        foreach ($obrasBBDD as $obraBBDD){
            //DATO tipo de obra
            $tipoObra = tablaTiposObra::get()->where('id',$obraBBDD->tipo_obra)->first();
            $obraBBDD->tipo_obra = $tipoObra->nombre;

            //DATO tipo de estructura
            $tipoEstructura = tablaEstructuras::get()->where('id',$obraBBDD->tipo_estructura)->first();
            $obraBBDD->tipo_estructura = $tipoEstructura->nombre;

            //DATO estado de la obra
            $estado = tablaEstados::get()->where('id',$obraBBDD->estado)->first();
            $obraBBDD->estado = $estado->estado;

            //DATOS de la direccion
            $direccionBBDD = Direcciones::get()->where('id',$obraBBDD->direccion)->first();

            //datos de la calle
            $direccion = $direccionBBDD->calle.' '.$direccionBBDD->numero.' '.$direccionBBDD->piso;
            $obraBBDD->direccionString = $direccion;

            //datos de latitud y longitud
            $obraBBDD->latitud = $direccionBBDD->latitud;
            $obraBBDD->longitud = $direccionBBDD->longitud;

            //DATOS del solicitante
            $solicitante = Persona::get()->where('id',$obraBBDD->solicitante)->first();

            //ARRAY DATOS SOLICITANTE
            $datosSolicitante = [
                "nombre" => $solicitante->nombre." ".$solicitante->apellidos,
                "email" => $solicitante->email,
                "telefono" => $solicitante->telefono
            ];
            $obraBBDD->datosSolicitante = $datosSolicitante;

            //DATOS del tecnico
            $datosTecnico = [];
            if ($obraBBDD->tecnico != null){
                $tecnico = Persona::get()->where('id',$obraBBDD->tecnico)->first();

                //ARRAY DATOS TECNICO
                $datosTecnico = [
                    "nombre" => $tecnico->nombre." ".$tecnico->apellidos,
                    "email" => $tecnico->email,
                    "telefono" => $tecnico->telefono
                ];
            }else{
                //ARRAY DATOS TECNICO
                $datosTecnico = [
                    "nombre" => "No asignado",
                    "email" => "-----",
                    "telefono" => "-----"
                ];
            }
            $obraBBDD->datosTecnico = $datosTecnico;

            //APARTADO DE FECHA

            if ($obraBBDD->fecha_inicio == null){
                $obraBBDD->fecha_inicio = "No iniciada";
            }

            if ($obraBBDD->fecha_fin == null){
                $obraBBDD->fecha_fin = "No acabada";
            }
        }
        return $obrasBBDD;
    }
}
