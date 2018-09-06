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
    <h4>Curso: {{ $diploma->name }}</h4><br>
    <p>Preguntas contestadas correctamente: {{ $summatory }} de {{ $numQuestions }}</p><br>
    <strong>Su calificación: {{ round($evaluationAverage, 2) }} </strong>
    <br>
    @if($evaluationAverage >= $diploma->minimum_score)
    <br><br>
    <h3>Felicidades, ha aprobado la evaluación para obtener su diploma</h3>
    <a href="{{ route('download.diploma.of.course', [$ascription->slug, $diploma->slug]) }}" target="_blank" class="btnAcademia">Descargar diploma</a>
    @else
    <h3>Lamentablemente no aprobó la evaluación</h3>
    <br><br>
    <a href="{{ route('show.diploma', [$ascription->slug, $diploma->slug]) }}" class="btnAcademia" >Atrás</a>
    <a href="{{ route('certificates.list', $ascription->slug) }}">Ver cerfificados disponibles</a>
    @endif
  </div>
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop