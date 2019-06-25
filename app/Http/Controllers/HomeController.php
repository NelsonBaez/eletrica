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
                'min:1',
                'max:12',
            ],
            'r1' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value > 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value > 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                }
            ],
            'r2' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value > 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value > 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                },
            ],
            'r3' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use($request) {
                    if ($request->tipo === 'Kohm' AND $value > 100) {
                        $fail($attribute.' deve ser menor ou igual a 100 Kohm.');
                    }elseif($request->tipo === 'Ohm' AND $value > 100000){
                        $fail($attribute.' deve ser menor ou igual a 100.000 Ohms.');
                    }
                },
            ],
        ]);
        $req_serie = $request->r1 + $request->r2 + $request->r3;
        $req_12 = ($request->r1 * $request->r2) / ($request->r1 + $request->r2);
        $req_paralelo =  ($req_12 * $request->r3) / ($req_12 + $request->r3);
        $req_misto = $req_12 + $request->r3;
        $tipo = $request->tipo;
        if($tipo == 'Kohm'){
            $tensao = $request->t;
            $tipo_ampere = 'mA';
            $tipo_potencia = 'mW';
        }else{
            $tipo_ampere = 'A';
            $tensao = $request->t;
            $tipo_potencia = 'W';
        }
        $corrente_total_serie = $tensao / $req_serie;
        $corrente_total_paralelo = $tensao / $req_paralelo;
        $corrente_total_misto = $tensao / $req_misto;
        
        $corrente_r1 = $tensao / $request->r1;
        $corrente_r2 = $tensao / $request->r2;
        $corrente_r3 = $tensao / $request->r3;
        $corrente_r12 = $tensao / $req_12;
        // Tensões parciais
        // Tensões Mostrando Corrente
        // 
        //
        //
        //
        //
        $tensao_serie = new \stdClass();
        $tensao_serie->r1 = $request->r1 * $corrente_total_serie;
        $tensao_serie->r2 = $request->r2 * $corrente_total_serie;
        $tensao_serie->r3 = $request->r3 * $corrente_total_serie;
        
        $tensao_mista = new \stdClass();
        $tensao_mista->r1 = $request->r1 * $corrente_r1;
        $tensao_mista->r2 = $request->r2 * $corrente_r2;
        $tensao_mista->r3 = $request->r3 * $corrente_total_misto;
        
        $tensao_paralela = new \stdClass();
        $tensao_paralela->r1 = $request->r1 * $corrente_r1;
        $tensao_paralela->r2 = $request->r2 * $corrente_r2;
        $tensao_paralela->r3 = $request->r3 * $corrente_r3;
        
        $potencia_serie = new \stdClass();
        $potencia_serie->p1 = $tensao_serie->r1 * $corrente_total_serie;
        $potencia_serie->p2 = $tensao_serie->r2 * $corrente_total_serie;
        $potencia_serie->p3 = $tensao_serie->r3 * $corrente_total_serie;
        
        $potencia_mista = new \stdClass();
        $potencia_mista->p1 = $tensao_mista->r1 * $corrente_r1;
        $potencia_mista->p2 = $tensao_mista->r2 * $corrente_r2;
        $potencia_mista->p3 = $tensao_mista->r3 * $corrente_total_misto;
        
        $potencia_paralela = new \stdClass();
        $potencia_paralela->p1 = $tensao_paralela->r1 * $corrente_r1;
        $potencia_paralela->p2 = $tensao_paralela->r2 * $corrente_r2;
        $potencia_paralela->p3 = $tensao_paralela->r3 * $corrente_r3;
        
        if($corrente_total_serie < 0.01){
            $corrente_total_misto = $corrente_total_misto * 1000;
            $corrente_r1 = $corrente_r1 * 1000;
            $corrente_r12 = $corrente_r12 * 1000;
            $corrente_r2 = $corrente_r2 * 1000;
            $corrente_r3 = $corrente_r3 * 1000;
            $corrente_total_paralelo = $corrente_total_paralelo * 1000;
            $corrente_total_serie = $corrente_total_serie * 1000;
            $tipo_ampere = 'mA';
        }
        if($potencia_serie->p1 < 0.01){
            $tipo_potencia = 'mW';
            $potencia_mista->p1 = $potencia_mista->p1 * 1000;
            $potencia_mista->p2 = $potencia_mista->p2 * 1000;
            $potencia_mista->p3 = $potencia_mista->p3 * 1000;
            $potencia_paralela->p1 = $potencia_paralela->p1 * 1000;
            $potencia_paralela->p2 = $potencia_paralela->p2 * 1000;
            $potencia_paralela->p3 = $potencia_paralela->p3 * 1000;
            $potencia_serie->p1 = $potencia_serie->p1 * 1000;
            $potencia_serie->p2 = $potencia_serie->p2 * 1000;
            $potencia_serie->p3 = $potencia_serie->p3 * 1000;
        }
        
        $request->flash();
        return view('welcome', ['req_serie' => $req_serie,
            'corrente_total_serie' => $corrente_total_serie, 'corrente_total_paralelo' => $corrente_total_paralelo, 'corrente_total_misto' => $corrente_total_misto, 
            'corrente_r1' => $corrente_r1, 'corrente_r2' => $corrente_r2, 'corrente_r3' => $corrente_r3,
            'corrente_r12' => $corrente_r12, 'tensao_serie' => $tensao_serie, 'tensao_mista' => $tensao_mista,
            'tensao_paralela' => $tensao_paralela, 'potencia_serie' => $potencia_serie, 'potencia_mista' => $potencia_mista,
            'potencia_paralela' => $potencia_paralela, 'req_paralelo' => $req_paralelo, 'req_misto' => $req_misto, 'tipo' => $tipo,
            'tipo_potencia' => $tipo_potencia,'tipo_ampere' => $tipo_ampere]);
    }
}
