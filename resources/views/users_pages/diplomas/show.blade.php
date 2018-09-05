@section('title')
Evaluacion
@stop

@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="#" class="breadcrumb">{{ $diploma->name }}</a>
@stop

@section('body')
    @include('users_pages.diplomas.info-modal')
    <div class="row pad-left3">
        <div class="col s6 l6">
            <hr class="line"/>
        </div>
        <div class="col s6 l6">
            <h2 class="recientes">Diplomado: {{ $diploma->name }}</h2>
        </div>
        <div style="text-align: center;">
            <button class="btnAcademia" >
                Inscribirse en el diplomado
            </button>
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
    $(document).ready(function() {
        $('#info-diploma').modal('open');
        setTimeout(function(){
            $('#info-diploma').modal('close');
        }, 5000);
    });  
    // $.ajax({
    //     type: 'get',
    //     url: "{{ route('draw.evaluation.form', [$ascription->slug, 'course', 'evaluation']) }}",
    //     success: function (result) {
    //         $('#evaluation-div').html(result);
    //     },
    //     error: function(request, error){
    //         console.log(error);
    //     }
    // });
    // cambiarItem("evaluaciones");
    // $(document).ready(function() {
    //     $('select').material_select();
    // });
</script>
@stop