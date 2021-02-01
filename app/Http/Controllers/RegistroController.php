<?php

namespace App\Http\Controllers;

use App\Models\Direcciones;
use App\Models\Persona;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function store(){

        request()->validate([
            'nombre'=>'required|regex:/^[A-zÀ-ÿ]+([ ]+[A-zÀ-ÿ]+)*$/i',
            'apellidos'=>'required|regex:/^([A-ZÀ-ÿ]{2,}\s?)+$/i',
            'dni'=>'required|regex:/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i',
            'fnacimiento'=>'required',
            'pais_nacimiento'=>'required|regex:/^[A-zÀ-ÿ]+([ ]+[A-zÀ-ÿ]+)*$/i',
            'tel'=>'required|min:9',
            'pass'=>'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
            'pass2'=>'required',
            'direccion'=>'required',
            'numero'=>'required|regex:/[1-9]+[0-9]*/',
            'piso'=>'required|regex:/^[0-9]+[\- ]?[a-zA-Z]+$/',
            'email'=>'required|email',
            'condiciones'=>'required'
        ], [
            'apellidos.regex'=>'Formato inválido: sólo puede contener letras',
            'fnacimiento.required'=>'La fecha de nacimiento es obligatoria',
            'pass.regex'=>'Debe contener mínimo 8 caracteres: al menos una mayúscula, una minúscula y un número',
            'pass2.required'=>'Confirmación de contraseña obligatoria'
        ]);

        //acceder a los datos de dirección

        $calle = request('calle');
        $numero = request('numero');
        $piso = request('piso');
        $cod_postal = request('cod_postal');
        $latitud = request('latitud');
        $longitud = request('longitud');

        //debemos verificar si ya existe:
        $dir = Direcciones::get()->where('calle',$calle)->where('numero',$numero)->where('piso',$piso)->first();
        //si no existe: insert de dirección
        if ($dir==null) {
            $dir = Direcciones::create([
                'calle' => $calle,
                'numero' => $numero,
                'piso' => $piso,
                'cod_postal' => $cod_postal,
                'latitud' => $latitud,
                'longitud' => $longitud
            ]);
        }
        //en cualquier caso nos quedamos con el id
        $idDir =  $dir->id;
        //añadir persona
        $dni = request('dni');
        //antes de hacer el insert debemos verificar si ya existe en la tabla con el dni
        $persona = Persona::find($dni);
        if($persona==null){
            //si no existe añadimos persona
            $persona = Persona::create([
                'id'=>$dni,
                'nombre'=>request('nombre'),
                'apellidos'=>request('apellidos'),
                'fecha_nacimiento'=>request('fnacimiento'),
                'pais_nacimiento'=>request('pais_nacimiento'),
                'direccion'=>$idDir,
                'email'=>request('email'),
                'telefono'=>request('tel'),
                'rol'=>2, //por defecto rol de usuario normal.
                'password'=>request('pass')
            ]);
            //redirigir al login y mostrar mensaje de registro exitoso
            $registro = true;
            $roles = Roles::get();
            return view('login',compact('roles','registro'));
        }
        //si ya existe debemos mostrar un mensaje de error en la vista de registro
        else{
            $registro =false;
            return view('registro',compact('registro'));
            //return "ya estás registrado";
        }



    }
}
