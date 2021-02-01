<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function contact(Request $request){


        request()->validate([
            'email' => 'required|email',
        ]);

        $subject = "asunto";

        $for = $request['email'];

        $user = Persona::get()->where('email', $for)->first();


        if (empty($user)) {
            $dato='red';
            return view('emailtest',compact('dato'))->with('botonNav', 'INICIAR SESION');
        } else {

            Mail::send('email', $request->all(), function ($msj) use ($subject, $for) {
                $msj->from("correoEmisor@gmail.com", "ivan");
                $msj->subject($subject);
                $msj->to($for);
            });


            return redirect()->route('confirmacion')->with(['message'=>$for]);

        }


    }
}
