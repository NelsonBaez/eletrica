@extends('layouts.app')    <!-- extende o codigo de Layout\app -->
    @section('pagetitle', 'index')
    @section('content')  <!-- define que o codigo dentro dessa variavel é o conteudo expresso na extenção -->
        <main role="main">
            <div class="container-fluid py-4"> 
                <div class="row justify-content-around mt-5 mb-5">
                    <div class="col-md-12 text-center">
                        <h3>Calculo de resistores</h3>
                    </div>
                </div>
                <div class="bg-white p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif (Session::has('mensagem_sucesso'))
                        <div class="alert alert-success">
                            {{ Session::get('mensagem_sucesso') }}
                        </div>
                    @endif
                    {{ Form::open(['url' => '/calculo', 'method' => 'POST']) }}
                        <div class="form-row text-center">
                            <div class="form-group col-md-3">
                                {!! Form::label('t', 'Tensão (t)', ['class' => 'col-form-label']) !!}
                                {!! Form::text('t', null, ['class' => 'form-control', 'autofocus']) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('r1', 'Resistor 1 (r1)', ['class' => 'col-form-label']) !!}
                                {!! Form::text('r1', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('r2', 'Resistor 2 (r2)', ['class' => 'col-form-label']) !!}
                                {!! Form::text('r2', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('r3', 'Resistor 3 (r3)', ['class' => 'col-form-label']) !!}
                                {!! Form::text('r3', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('tipo', 'Valores em Ohm ou Kohm', ['class' => 'col-form-label']) !!}
                                {!! Form::select('tipo', ['Kohm' => 'Kohm', 'Ohm' => 'Ohm'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-row text-center">
                            <div class="form-group col-md-12">
                                {{ Form::submit('Calcular',['class' => 'btn btn-primary'])}}
                            </div>
                        </div>
                    {{ Form::close()}}
                </div>
                <div class="bg-white p-5 mt-5 h4">
                    <div class="form-row ">
                        <div class="col-md-4">
                            <div class="rowtext-center">
                                <h3>Associados em Série</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Req:
                                </div>
                                @if(isset($req_serie))
                                    <div class="col-md-6">
                                        <span class="text-primary">{{ number_format($req_serie,2,',','.') }} {{ $tipo }}</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Corrente Total:
                                </div>
                                @if(isset($corrente_total_serie))
                                    <div class="col-md-3">
                                        <span class="text-primary">{{ number_format($corrente_total_serie,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Tensões:
                                </div>
                                @if(isset($tensao_serie))
                                    <div class="col-md-3">
                                        V1: <span class="text-primary">{{ number_format($tensao_serie->r1,2,',','.') }}V</span>
                                    </div>
                                    <div class="col-md-3">
                                        V2: <span class="text-primary">{{ number_format($tensao_serie->r2,2,',','.') }}V</span>
                                    </div>
                                    <div class="col-md-3">
                                        V3: <span class="text-primary">{{ number_format($tensao_serie->r3,2,',','.') }}V</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Potencias:
                                </div>
                                @if(isset($potencia_serie))
                                    <div class="col-md-3">
                                        P1: <span class="text-primary">{{ number_format($potencia_serie->p1,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P2: <span class="text-primary">{{ number_format($potencia_serie->p2,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P3: <span class="text-primary">{{ number_format($potencia_serie->p3,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                @endif                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rowtext-center">
                                <h3>Associados em Paralélo</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Req:
                                </div>
                                @if(isset($req_paralelo))
                                    <div class="col-md-6">
                                        <span class="text-primary">{{ number_format($req_paralelo,2,',','.') }} {{ $tipo }}</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Corrente Total:
                                </div>
                                @if(isset($corrente_total_paralelo))
                                    <div class="col-md-3">
                                        <span class="text-primary">{{ number_format($corrente_total_paralelo,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Correntes Parciais:
                                </div>
                                @if(isset($corrente_total_paralelo))
                                    <div class="col-md-3">
                                        I1:<span class="text-primary">{{ number_format($corrente_r1,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                    <div class="col-md-3">
                                        I2:<span class="text-primary">{{ number_format($corrente_r2,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                    <div class="col-md-3">
                                        I3:<span class="text-primary">{{ number_format($corrente_r3,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Tensões:
                                </div>
                                @if(isset($tensao_paralela))
                                    <div class="col-md-9">
                                        V1 = V2 = V3: <span class="text-primary">{{ number_format($tensao_paralela->r1,2,',','.') }}V</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Potencias:
                                </div>
                                @if(isset($potencia_paralela))
                                    <div class="col-md-3">
                                        P1: <span class="text-primary">{{ number_format($potencia_paralela->p1,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P2: <span class="text-primary">{{ number_format($potencia_paralela->p2,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P3: <span class="text-primary">{{ number_format($potencia_paralela->p3,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                @endif                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rowtext-center">
                                <h3>Associados em Misto</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Req:
                                </div>
                                @if(isset($req_misto))
                                    <div class="col-md-6">
                                        <span class="text-primary">{{ number_format($req_misto,2,',','.') }} {{ $tipo }}</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Corrente Total:
                                </div>
                                @if(isset($corrente_total_misto))
                                    <div class="col-md-3">
                                        <span class="text-primary">{{ number_format($corrente_total_misto,2,',','.') . $tipo_ampere}} </span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Tensões:
                                </div>
                                @if(isset($tensao_mista))
                                    <div class="col-md-3">
                                        V1: <span class="text-primary">{{ number_format($tensao_mista->r1,2,',','.') }}V</span>
                                    </div>
                                    <div class="col-md-3">
                                        V2: <span class="text-primary">{{ number_format($tensao_mista->r2,2,',','.') }}V</span>
                                    </div>
                                    <div class="col-md-3">
                                        V3: <span class="text-primary">{{ number_format($tensao_mista->r3,2,',','.') }}V</span>
                                    </div>
                                @endif                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Potencias:
                                </div>
                                @if(isset($potencia_mista))
                                    <div class="col-md-3">
                                        P1: <span class="text-primary">{{ number_format($potencia_mista->p1,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P2: <span class="text-primary">{{ number_format($potencia_mista->p2,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                    <div class="col-md-3">
                                        P3: <span class="text-primary">{{ number_format($potencia_mista->p3,2,',','.') . $tipo_potencia}}</span>
                                    </div>
                                @endif                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection
