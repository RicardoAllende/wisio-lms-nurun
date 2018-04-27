@extends('layouts.app')

@section('title','Evaluación '.$evaluation->name)
@section('cta')
  <a href="/evaluations/{{ $evaluation->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i>Editar evaluación</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <!--<h5>Datos del Evaluación</h5>-->
                <a href="{{action('ModulesController@show', $evaluation->id)}}">
                    {{ (strlen($evaluation->name) > 15) ? substr($evaluation->name, 0, 15).'...' : $evaluation->name }}
                </a> / 
            </div>
            <div class="ibox-content">
                <div class="contact-box">
                    <div class="col-sm-8">
                        <h3><strong>Nombre: {{ $evaluation->name }} </strong></h3>
                        <p>Tipo de evaluación: {{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }} </p>
                        <p>Descripción: {{ $evaluation->description }} </p>
                    </div>
                    <div class="clearfix">
                        Intentos permitidos: {{ $evaluation->maximum_attemps }}
                        Calificación mínima: {{ $evaluation->minimum_score }}
                    </div>
                        
                </div>

            @if ($evaluation->questions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo de pregunta</th>
                            <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($evaluation->questions as $question) 
                                <tr>
                                <td><a href="{{ action('QuestionsController@show', $question->id) }}">{{ $i }}</a></td>
                                <td><a href="{{ action('QuestionsController@show', $question->id) }}">{{ $question->name }}</a></td>
                                <td>
                                @if ($question->type == "2") <!-- Opción múltiple-->
                                    Opción Múltiple
                                @else <!-- Verdadero Falso -->
                                    Verdadero/falso
                                @endif
                                </td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['questions.destroy',$question->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
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
                <h3><strong>Esta evaluación aún no tiene preguntas, desea agregar alguna?</strong></h3><br>
                <a href="{{ route('form.upload.questions') }}" class="btn btn-info">Agregar masivamente en formato GIFT</a>&nbsp;
                <a href=" {{ action('QuestionsController@create') }}" class="btn btn-info">Agregar pregunta</a>
            @endif
            </div>
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