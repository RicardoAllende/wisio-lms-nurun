@extends('layouts.app')

@section('title','Quiz')
@section('cta')
  <a href="/quizzes/{{ $quiz->id }}/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar quiz</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos del Quiz</h5>
            </div>
            <div class="ibox-content">
            @if ($quiz->questions->count() > 0)
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
                            @foreach($quiz->questions as $question) 
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
                <h3><strong>Este quiz aún no tiene preguntas, desea agregar alguna?</strong></h3><br>
                <a href="{{ route('form.upload.questions') }}" class="btn btn-info">Agregar masivamente por formato GIFT</a>&nbsp;
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