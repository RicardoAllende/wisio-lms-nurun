@extends('layouts.app')

@section('title','Pregunta')
@section('cta')
  <a href="{{ action('QuestionsController@edit', $question->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Pregunta</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {{ $question->evaluation->module->name }}<br>
                    {{$question->evaluation->name}}
                    <a href="{{action('ModulesController@show', $question->evaluation->module->id)}}">
                        {{ (strlen($question->evaluation->module->name) > 15) ? substr($question->evaluation->module->name, 0, 15).'...' : $question->evaluation->module->name }}
                    </a> / 
                    <a href="{{action('QuestionsController@show', $question->id)}}">
                        {{ (strlen($question->evaluation->name) > 15) ? substr($question->evaluation->name, 0, 15).'...' : $question->evaluation->name }}
                    </a> / 
                </div>
            <div class="contact-box">
                <div class="col-sm-6">
                    <h3>Nombre de la pregunta: {{ $question->name }}</h3>
                    <h3><strong> Contenido de la pregunta: {{ $question->content }} </strong></h3>
                </div>
                <div class="col-sm-6">
                    @if($question->hasOptions())
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Respuesta</th>
                                    <th>Valor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($question->options as $option) 
                                    <tr>
                                        <td><a href="{{ action('OptionsController@show', $option->id) }}">{{ $i }}</a></td>
                                        <td><a href="{{ action('OptionsController@show', $option->id) }}">{{ $option->content }}</a></td>
                                        <td>{{ ($option->score == 1) ? 'Correcto' : 'Incorrecto' }}</td>
                                        <td>
                                            {!! Form::open(['method'=>'DELETE','route'=>['options.destroy',$option->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                                <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        Esta pregunta aún no tiene opciones
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