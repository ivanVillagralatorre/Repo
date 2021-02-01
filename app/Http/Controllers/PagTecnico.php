<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Direcciones;
use App\Models\tablaEstados;
use App\Models\tablaEstructuras;
use App\Models\tablaObras;
use App\Models\tablaTiposObra;
use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PagTecnico extends Controller
{
    public function extraerObras($condicion){
        $dni = $_SESSION["user"]["id"];
        $obraBBDD = [];

        if ($condicion == 1){
            $obrasBBDD = tablaObras::get()->where('tecnico',$dni)->where('estado',$condicion);
        }else{
            $obrasBBDD = tablaObras::where('tecnico',$dni)->where('estado', '!=' ,1)->paginate(5);
        }



        foreach ($obrasBBDD as $obraBBDD){
            //DATO tipo de obra
            $tipoObra = tablaTiposObra::get()->where('id',$obraBBDD->tipo_obra)->first();
            $obraBBDD->tipo_obra = $tipoObra->nombre;

            //DATO tipo de estructura
            $tipoEstructura = tablaEstructuras::get()->where('id',$obraBBDD->tipo_estructura)->first();
            $obraBBDD->tipo_estructura = $tipoEstructura->nombre;

            //DATO estado de la obra
            $estado = tablaEstados::get()->where('id',$obraBBDD->estado)->first();
            $obraBBDD->estadoString = $estado->estado;

            switch ($estado->id){
                case 2:
                    $obraBBDD->mensajeCambiarEstado = "Iniciar Obra";
                    break;
                case 3:
                    $obraBBDD->mensajeCambiarEstado = "Finalizar Obra";
                    break;
            }

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

    public function cambiarEstado($estado,$id){
        $obra = tablaObras::find($id);
        $nuevoEstado = $estado+1;
        if ($estado == 2){
            $obra->fecha_inicio = date("Y-m-d H:i:s");
        }else{
            $obra->fecha_fin = date("Y-m-d H:i:s");
        }
        $obra->estado = $nuevoEstado;
        $obra->save();
        return back();
    }

    public function aceptarObra($id){
        $obra = tablaObras::find($id);
        $obra->estado = 2;
        $obra->save();
        $this->enviarCorreo(0,$obra);
        return back();
    }

    public function denegarObra($id){
        $obra = tablaObras::find($id);
        if ($obra->plano != null){
           $this->eliminarArchivo($obra->plano);
        }
        $this->enviarCorreo(1,$obra);
        tablaObras::where('id',$id)->delete();
        return back();
    }

    public function enviarCorreo($accion,$obra){
        $dni = $obra->solicitante;
        $solicitante = Persona::get()->where('id',$dni)->first();
        $subject = "Obra solicitada al ayuntamiento";
        $for = $solicitante->email;
        if ($accion == 0){
            $accion2 = "Aceptada";
        }else{
            $accion2 = "Denegada";
        }

        $datos = [
            "obra" => $obra,
            "accion" => $accion2
        ];

        Mail::send('emailObraAceptadaDenegada', $datos, function ($msj) use ($subject, $for) {
            $msj->from("correoEmisor@gmail.com", "Ayuntamiento de Vitoria-Gasteiz");
            $msj->subject($subject);
            $msj->to($for);
        });
    }

    public function eliminarArchivo($archivo){
        Storage::delete("planos/".$archivo);
    }
}
