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
  <div>
  <!-- 'numQuestions', 'evaluation', 'summatory', 'evaluationAverage', 'course', 'module', 'ascriptionSlug', 'moduleAvg' -->
    <h4>Resultados de la evaluación {{ $evaluation->name }}</h4>
    <p>Número de preguntas en la evaluación: {{ $numQuestions }} </p>
    <p>Preguntas contestadas correctamente: {{ $summatory }} </p>
    <p>Calificación: {{ $evaluationAverage }} </p>
    <p>Tipo de evaluación: {{ ($evaluation->isFinalEvaluation()) ? 'Evaluación final' : 'Evaluación diagnóstica' }}</p>
    <br>
    <a href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Volver atrás</a>
  </div>
</div>
@stop
@section('extrajs')
<script>
  // console.log("Hola".serialize());
  cambiarItem("evaluaciones");
</script>
@stop
