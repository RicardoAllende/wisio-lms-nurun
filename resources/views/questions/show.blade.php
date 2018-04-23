@extends('layouts.app')

@section('title','Question')
@section('cta')
  <a href="{{ action('QuestionsController@edit', $question->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Pregunta</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Datos de la pregunta</h5>
                </div>
            <div class="contact-box">
                <div class="col-sm-12">
                    <h3>Nombre de la pregunta: {{ $question->name }}</h3>
                    @if($question->type == '1')
                        <h3><strong> {{$question->content}} Opción correcta: @if ($question->correct == '0') Falso @else Verdadero @endif </strong></h3>
                    @endif
                    @if($question->type == '2')
                        <h3><strong> Respuestas a: {{ $question->content }} </strong></h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Respuesta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($question->options as $option) 
                                        <tr>
                                            <td><a href="{{ action('OptionsController@show', $option->id) }}">{{ $option->position }}</a></td>
                                            <td><a href="{{ action('OptionsController@show', $option->id) }}">{{ $option->content }}</a></td>
                                            <td>
                                                {!! Form::open(['method'=>'DELETE','route'=>['options.destroy',$option->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                                    <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                    
            </div>
            <a href="{{ action('EvaluationsController@show',$question->evaluation->id) }}" class="btn btn-primary" >Atrás</a>
            <a href="{{ action('OptionsController@createFor',$question->id) }}" class="btn btn-primary" >Agregar opción</a>

            </div>
        </div>
	</div>
</div>
@endsection
@section('scripts')
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/method_delete_f.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection