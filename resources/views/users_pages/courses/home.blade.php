@section('title')
Inicio
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
@stop

@section('body')

        @if(Auth::check())
        <div class="row pad-left3">
          <div class="col s4 l9">
             <hr class="line"/>
          </div>
          <div class="col s8 l3">
             <h2 class="recientes">cursos recomendados</h2>
          </div>
          @if($recommendations->count() > 0)
          @foreach($recommendations as $course)
          <div class="col s12 l4 ">
            <div class="card z-depth-0 white ">
               <div class="card-content cursoscard">
                  <span class="categoria-academia">{{ $course->category->name }}</span>
                 <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
                  <h4 class="titulo-academia2"> {{ $course->name }}</h4>
                   <div class="modulos">{{ $course->modules->count() }} módulos</div>
                  <div class="leer-masmodulos_50">
                  @if(Auth::check())
                     <a href="{{ route('student.show.course', [$ascription->slug,$course->slug]) }}">Ver mas</a>
                  @else
                     <a href="{{ route('student.show.course', 'invitado') }}">Ver mas  </a>
                  @endif
                      <hr class="line3"/>
                  </div>
                 <div class="leer-masmodulos">
                    @if(Auth::user()->isEnrolledInCourse($course->id))
                      <a href="#">Inscrito</a>
                    @else
                      <a href="{{ route('student.enrol.course', [$ascription->slug,Auth::user()->id,$course->id]) }}" >Inscribirse</a>
                    @endif
                    <hr class="line3"/>
                  </div>
               </div>
            </div>
          </div>
          @endforeach
          @else
            <div class="col s12 14">
              No hay cursos disponibles para recomendarte en este momento.
            </div>
          @endif
          @endif

       </div>


@include('users_pages.courses.newest')
@stop

@section('extrajs')
<script>
  cambiarItem("home");
</script>
@stop