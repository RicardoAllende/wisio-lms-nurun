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
    <h2 class="recientes">Resultados de la evaluación</h2>
  </div>
  <div><br>
    <h4>Resultados de la evaluación: {{ $evaluation->name }}</h4><br>
    <p>Número de preguntas en la evaluación: {{ $numQuestions }} </p><br>
    <p>Preguntas contestadas correctamente: {{ $summatory }} </p>
    <p>Calificación: {{ $evaluationAverage }} </p>
    <p>Tipo de evaluación: {{ ($evaluation->isFinalEvaluation()) ? 'Evaluación final' : 'Evaluación diagnóstica' }}</p>
    <br>
    <a class="btnAcademia" href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Volver atrás</a>
  </div>
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop
