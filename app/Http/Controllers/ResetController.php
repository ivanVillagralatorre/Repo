<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Roles;
use Illuminate\Http\Request;


class ResetController extends Controller
{

    public function index(){

        if (!isset($_GET['email']))
        {
            $dato ='none';
            $roles = Roles::get();
            return view('login',compact('roles'),compact('dato'));
        }
        return view('reset');
    }

    public function update(){


        $mail = base64_decode(request('correo'));

          $user = Persona::get()->where('email',$mail )->first();

         $user->update([
                'password'=> request('pass1')
        ]);


        $dato ='none';
        $roles = Roles::get();
        return view('login',compact('roles'),compact('dato'));

    }


}
