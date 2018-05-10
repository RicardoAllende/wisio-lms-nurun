@extends('layouts.app')

@section('title','Evaluación '.$evaluation->name)
@section('cta')
  <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn btn-primary "><i class='fa fa-edit'></i>Editar evaluación</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">

        <div class="widget-head-color-box navy-bg p-lg text-center">
            <div class="row">
                <div class="col-sm-4">
                    <div class="m-b-md">
                    <h2 class="font-bold no-margins">
                        {{$evaluation->name}}
                    </h2>
                        <small>Nombre de la evaluación</small>
                    </div>
                    <img src="{{$evaluation->img_url()}}" width="32%" height="18%" class="img-circle m-b-md" alt="Imagen del módulo">
                </div>
                <div class="col-sm-8" style="bottom: 50%;">
                <br><br><br>
                    <p>Tipo de evaluación: {{ ($evaluation->type == 'd')? 'Diagnóstica' : 'Final' }} Intentos permitidos: {{ $evaluation->maximum_attemps }}</p>
                    <p>Calificación mínima: {{ $evaluation->minimum_score }}</p>
                    <span>Pertenece al módulo: {{ $evaluation->module->name }}</span> |
                    <span>Contiene {{ $evaluation->questions->count() }} preguntas</span> |
                    <span>{{ $approved }} Veces aprobado</span>
                </div>
                
            </div>
            
                
        </div>
        <div class="widget-text-box">
            <h4 class="media-heading">Descripción de la evaluación</h4>
            <p>{{$evaluation->description}}. Fecha de inicio: {{ $evaluation->start_date }}, Fecha de término: {{ $evaluation->end_date }}</p>
        </div>


        <div class="ibox float-e-margins">
            
            <div class="ibox-content">
                
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
                <!--<a href="{{ route('form.upload.questions') }}" class="btn btn-info">Agregar masivamente en formato GIFT</a>&nbsp;-->
                <a href=" {{ route('questions.create') }}?evaluation_id={{$evaluation->id}}" class="btn btn-info">Agregar pregunta</a>
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