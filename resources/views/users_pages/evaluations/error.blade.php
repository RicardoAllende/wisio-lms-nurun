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
    <h4>Ocurrió un error: {{ $evaluation->name }}, contacte con su administrador {{ config('constants.support_email') }}. Error evaluación </h4>
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
