@section('title')
Cursos
@stop
@extends('users_pages.master')
@section('body')
<div class="row pad-left3">
  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">cursos</h2>
  </div>
  @foreach($courses as $course)
  <div class="col s12 l4 ">
    <div class="card z-depth-0 white ">
       <div class="card-content mods">
          <span class="categoria-academia">{{ $course->category->name }}</span>
         <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
          <div class="titulo-academia2"> {{ $course->name }}</div>
           <div class="modulos">{{ $course->modules->count() }} módulos</div>
              <div  class="moduloslista valign-wrapper">

                    <ol>
                      @foreach($course->modules as $module)
                        <li>{{ $module->name }} </li>
                      @endforeach
                    </ol>
              </div >
          <div class="leer-masmodulos_50">
            @if(Auth::check())
              <a href="{{ route('student.show.course', [Auth::user()->ascription()->slug,$course->slug]) }}">Ver todo</a>
            @else
              <a href="{{ route('welcome') }}">ver mas</a>
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
  cambiarItem("cursos");
</script>
@stop
