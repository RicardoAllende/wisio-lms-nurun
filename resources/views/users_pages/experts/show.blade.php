@section('title')
Experto {{ $expert->name }}
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.experts' , $ascription->slug) }}" class="breadcrumb">Profesores</a>
  <a href="" class="breadcrumb">{{ $expert->name }}</a>
@stop

@section('body')

<div class="row pad-left3">

     <h4 class="tits">Experto</h4>

  <div class="col s9 offset-s1">
     <div class="card z-depth-0 white ">
        <div class="card-content ">
          <div class="row valign-wrapper">
              <div class="col s3">
                <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
              </div>
             <div class="col s9 expertostitulo">{{ $expert->name}}</div>
            </div>

            <div class="expertosparticipacion">
              <p class="upper">Participa en:</p>
              <ul class="browser-default">
                @foreach($expert->modulesFromAscription($ascription->id, $ascription->slug) as $link)
                  <li>{!! $link !!}</li>
                @endforeach
              </ul>
            </div>
            <div class="expertosparticipacion2">
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
