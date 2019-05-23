@extends('layouts.app')    <!-- extende o codigo de Layout\app -->
    @section('pagetitle', 'index')
    @section('content')  <!-- define que o codigo dentro dessa variavel é o conteudo expresso na extenção -->
        <main role="main">
            <div class="container py-4 px-2"> 
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
                    <div class="form-row text-center">
                        <div class="col-md-4">
                            Req em série:
                            @if(isset($req_serie))
                                <span class="text-primary">{{ number_format($req_serie,2,',','.') }} {{ $tipo }}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            Req em paralelo:
                            @if(isset($req_paralelo))
                                <span class="text-primary">{{ number_format($req_paralelo,2,',','.') }} {{ $tipo }}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            Req com r1 e r2 em paralelo, série com o r3:
                            @if(isset($req_misto))
                                <span class="text-primary"> {{ number_format($req_misto,2,',','.') }} {{ $tipo }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection
