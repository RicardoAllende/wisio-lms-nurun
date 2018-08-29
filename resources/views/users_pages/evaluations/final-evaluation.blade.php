@section('title')
Evaluacion
@stop

@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.course', [$ascription->slug, $course->slug]) }}" class="breadcrumb">Curso {{ $course->name }}</a>
  <a href="{{ route('student.show.course', [$ascription->slug, $course->slug]) }}" class="breadcrumb">Módulos</a>
  <a href="{{ route('show.evaluation.course' , [$ascription->slug, $course->slug]) }}" class="breadcrumb">Evaluaciones</a>
@stop

@section('body')
@include('users_pages.evaluations.info-evaluation')
    <div class="row pad-left3">
        <div class="col s6 l6">
            <hr class="line"/>
        </div>
        <div class="col s6 l6">
            <h2 class="recientes">Evaluación final del módulo: {{ $module->name }}</h2>
        </div>
        <div id="evaluation-div" style="min-height: 600px;"></div>
    </div>
@stop

@section('extracss')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .circle-selected, .circle-dot:hover {
    background-color: #8F6EAA;
    }
    .purple-text{
    color: #8F6EAA;
    cursor: pointer;
    }
    .circle-dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
    }
    .circle-not-selected{
    background-color: #e9e9e9;
    }
</style>
@endsection

@section('extrajs')
<script>
    $.ajax({
        type: 'get',
        url: "{{ route('draw.evaluation.form', [$ascription->slug, $course->slug, $evaluation->id]) }}",
        success: function (result) {
            $('#evaluation-div').html(result);
        },
        error: function(request, error){
            console.log(error);
        }
    });
    cambiarItem("evaluaciones");
    $(document).ready(function() {
        $('select').material_select();
    });
    $(document).ready(function() {
        $('#info-evaluation').modal('open');
        setTimeout(function(){
            $('#info-evaluation').modal('close');
        }, 5000);
    });  
</script>
@stop
