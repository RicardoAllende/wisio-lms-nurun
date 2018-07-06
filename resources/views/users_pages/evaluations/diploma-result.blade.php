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
    <p>Preguntas contestadas correctamente: {{ $numQuestions }} de {{ $summatory }}</p><br>
    <strong>Su calificación: {{ $evaluationAverage }} </strong>
    <br>
    @if($evaluationAverage >= $course->minimum_diploma_score)
    <h3>Felicidades, ha aprobado la evaluación para obtener su diploma</h3>
    <a href="{{ route('download.diploma.of.course', [$ascription->slug, $course->slug]) }}"></a>
    @else

    @endif
    <a class="btnAcademia" href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Volver a evaluaciones del curso</a>
  </div>
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop