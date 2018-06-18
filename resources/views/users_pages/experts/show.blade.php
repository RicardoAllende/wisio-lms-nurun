@section('title')
Experto {{ $expert->name }}
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.experts' , $ascription->slug) }}" class="breadcrumb">Evaluaciones</a>
  <a href="" class="breadcrumb">{{ $expert->name }}</a>
@stop

@section('body')

<div class="row pad-left3">

     <h4 class="tits">Experto</h4>

  <div class="col s12">
     <div class="card z-depth-0 white ">
        <div class="card-content expertoscard">
          <div class="row valign-wrapper">
              <div class="col s4">
                <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
              </div>
             <div class="col s8 expertostitulo ">{{ $expert->name}}</div>
            </div>

            <div class="expertosparticipacion">
              <p class="upper">Participa en:</p>
              <ul class="browser-default">
                  <li>Introduccion</li>
                  <li>Creación de plan estratégico para hipertensión</li>
                  <li>Caso clínico: Entrevista Dr. Alcocer y Dr. Figueroa</li>
              </ul>
            </div>
            <div class="expertosparticipacion">
              <p class="upper">Resumen:</p>
              <div class="resumen">{!! $expert->summary !!}</div>
            </div>

        </div>
     </div>
  </div>

</div>

@stop

@section('extrajs')
<script>
  cambiarItem("expertos");
</script>
@stop
