<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function calculo(Request $request){
        $request->validate([
            't' => [
                'required',
                'integer',
                'min:0'
            ],
            'r1' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value >= 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value >= 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                },
            ],
            'r2' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value >= 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value >= 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                },
            ],
            'r3' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value >= 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value >= 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                },
            ],
        ]);
        $req_serie = $request->r1 + $request->r2 + $request->r3;
        $req_12 = ($request->r1 + $request->r2) / ($request->r1 * $request->r2);
        $req_paralelo =  ($req_12 + $request->r3) / ($req_12 * $request->r3);
        $req_misto = $req_12 + $request->r3;
        $tipo = $request->tipo;
        $request->flash();
        return view('welcome', ['req_serie' => $req_serie, 'req_paralelo' => $req_paralelo, 'req_misto' => $req_misto, 'tipo' => $tipo]);
    }
}
