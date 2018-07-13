@section('title')
Evaluaciones
@stop

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.course', [$ascription->slug, $course->slug]) }}" class="breadcrumb">Curso {{ $course->name }}</a>
  <a href="{{ route('student.show.course', [$ascription->slug, $course->slug]) }}" class="breadcrumb">{{ $module->name }}</a>
  <a href="#" class="breadcrumb">Evaluación final</a>
@stop

@extends('users_pages.master')
@section('body')
<div class="row pad-left3">
  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">Resultados de la evaluación</h2>
  </div>
  <div><br>
    <h4>Resultados de la evaluación: {{ $evaluation->name }}</h4><br>
    <p>Preguntas contestadas correctamente: {{ $summatory }} de {{ $numQuestions }}</p><br>
    <strong>Su calificación: {{ round($evaluationAverage, 2) }} </strong>
    <p>Evaluación final del módulo: <a href="{{ route('student.show.course', [$ascription->slug, $course->slug]) }}">{{ $module->name }}</a></p>
    <br>
    <a class="btnAcademia" href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Volver a evaluaciones del curso</a>
  </div>
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop
