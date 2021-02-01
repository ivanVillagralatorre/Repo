<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\tablaDirecciones;
use App\Models\tablaEstructuras;
use App\Models\tablaTiposObra;
use App\Models\tablaObras;
use App\Models\tablaEstados;
use Illuminate\Http\Request;
use App\Models\Persona;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isReadable;

class Logincontroller extends Controller
{
    //
    public function index()
    {
        $dato = 'none';
        $roles = Roles::get();
        return view('login', compact('roles'), compact('dato'));
    }

    public function login()
    {
        $dato = 'none';

        if (isset($_SESSION['user'])) {
            session_destroy();
        }

        session_start();

        request()->validate(
            [
                'dni' => 'required',
                'pass' => 'required'
            ]
        );

        $dni = request('dni');
        $pass = request('pass');
        $rol = request('rol');
        $user = Persona::get()->where('id', $dni)->where('password', $pass)->first();


        $roles = Roles::get();
        $dato = 'block';

        if (empty($user)) {
            session_destroy();

            return view('login', compact('roles'), compact('dato'));
        }

        $_SESSION['user'] = $user;




        switch ($user->rol) {
            case 0:
                if ($rol == 0) {
                    return view('welcome');
                } elseif ($rol == 2) {
                    return redirect('usuario');
                } else {
                    return view('login', compact('roles'), compact('dato'));
                }

            case 1:
                if ($rol == 1) {
                    return redirect('tecnico');
                } elseif ($rol == 2) {
                    return redirect('usuario');
                } else {

                    return view('login', compact('roles'), compact('dato'));
                }
                break;
            case 2:
                if ($rol == 2) {
                    return redirect('usuario');
                } else {

                    return view('login', compact('roles'), compact('dato'));
                }
        }

    }

}
