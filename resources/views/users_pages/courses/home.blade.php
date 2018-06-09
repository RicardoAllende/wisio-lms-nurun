@section('title')
Inicio
@stop
@extends('users_pages.master')
@section('body')


<div class="row pad-left3">
          <div class="col s6 l9">
             <hr class="line"/>
          </div>
          <div class="col s6 l3">
             <h2 class="recientes">cursos recomendados</h2>
          </div>
          @foreach($courses as $course)
          <div class="col s12 l4 ">
            <div class="card z-depth-0 white ">
               <div class="card-content cursoscard">
                  <span class="categoria-academia">{{ $course->category->name }}</span>
                 <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
                  <div class="titulo-academia2"> {{ $course->name }}</div>
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
                      Inscrito
                    @else
                      <a href="{{ route('student.enrol.course', [Auth::user()->ascription()->slug,Auth::user()->id,$course->id]) }}" >Inscribirse</a>
                    @endif
                    <hr class="line3"/>
                  </div>
               </div>
            </div>
          </div>
          @endforeach

       </div>


@include('users_pages.courses.newest')
@stop

@section('extrajs')
<script>
  cambiarItem("home");
</script>
@stop
