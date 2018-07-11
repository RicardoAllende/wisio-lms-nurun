@section('title')
Evaluaciones
@stop
@extends('users_pages.master')
@section('body')
<div class="row pad-left3">
  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">Resultados del diplomado</h2>
  </div>
  <div><br>
    <h4>Curso: {{ $course->name }}</h4><br>
    <p>Preguntas contestadas correctamente: {{ $summatory }} de {{ $numQuestions }}</p><br>
    <strong>Su calificación: {{ round($evaluationAverage, 2) }} </strong>
    <br>
    @if($evaluationAverage >= $course->minimum_diploma_score)
    <h3>Felicidades, ha aprobado la evaluación para obtener su diploma</h3>
    <a href="{{ route('download.diploma.of.course', [$ascription->slug, $course->slug]) }}">Descargar diploma</a>
    @else
    <h3Lamentablemente no aprobó la evaluación</h3>
    @endif
  </div>
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop