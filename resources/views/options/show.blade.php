@extends('layouts.app')

@section('title','Opciones a '.$option->question->name)
@section('cta')
  <a href="{{route('options.edit', $option->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Respuesta</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        @if($option->question->evaluation->isDiplomaEvaluation())
        <li>
            <a href="{{ route('diplomas.show', $option->question->evaluation->diploma->id) }}">Curso: {{ $option->question->evaluation->diploma->name }}</a>
        </li>
        @else
        <li>
            <a href="{{ route('courses.show', $option->question->evaluation->module->course->id) }}">Curso: {{ $option->question->evaluation->module->course->name }}</a>
        </li>
        @endif
        <li>
            <a href="{{ route('evaluations.show', $option->question->evaluation->id) }}">Módulo: {{ $option->question->evaluation->name }}</a>
        </li>
        <li>
            <a href="{{ route('questions.show', $option->question->id) }}">Pregunta: {{ $option->question->name }}</a>
        </li>
        <li>
            {{ $option->content }}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            @if($option->isCorrect())
                <div class="widget navy-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fas fa-check fa-4x"></i>
                        <h1 class="m-xs">456</h1>
                        <h3 class="font-bold no-margins">
                            Pregunta: {{ $option->question->content }}
                        </h3>
                        <h3>
                            Opción: < {{ $option->content }} >
                        </h3>
                        <small>Esta opción es una solución válida</small>
                    </div>
                </div>
            @else
                <div class="widget red-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fas fa-times fa-4x"></i>
                        <h1 class="m-xs">47</h1>
                        <h3 class="font-bold no-margins">
                            Opción: < {{ $option->content }} >
                        </h3>
                        <small>Esta respuesta está marcada como incorrecta.</small>
                    </div>
                </div>
            @endif
        </div>
      </div>
	</div>
</div>

                        


@endsection

@section('scripts')



@endsection

@section('styles')

@endsection