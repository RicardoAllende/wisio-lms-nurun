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
            @if(isset($finished))
                <br><br><br>
                Usted terminó el diploma con la siguiente calificación: 8.5
                

            @endif
        </div>
        <div style="text-align: center;">
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
    @if(isset($enrollment))
        @if( ! isset($finished) )
            $.ajax({
                type: 'get',
                url: "{{ route('draw.final.evaluation.form', [$ascription->slug, $enrollment->slug]) }}",
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
        @endif
    @else
        $(document).ready(function() {
            $('.modal').modal({
                // dismissible: false,
                complete: function(){
                    window.location.href = "{{ route('student.home', $ascription->slug) }}";
                }
            });
            $('#info-diploma').modal('open');
            // setTimeout(function(){
            //     $('#info-diploma').modal('close');
            // }, 5000);
        });
    @endif 
</script>
@stop