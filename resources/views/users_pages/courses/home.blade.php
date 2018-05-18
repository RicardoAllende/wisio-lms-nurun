@section('title')
Curso {{ $course->name }}
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
                  <span class="categoria-academia">{{ $course->categories->first()->name }}</span>
                 <div class="iconcourse"><img src="{{ $course->categories->first()->getMainImgUrl() }}" class="responsive-img"></div>
                  <div class="titulo-academia2"> {{ $course->name }}</div>
                   <div class="modulos">{{ $course->modules->count() }} módulos</div>
                  <div class="leer-masmodulos_50">
                     <a href="/student-courses/{{ $course->id }}">Ver mas</a>
                      <hr class="line3"/>
                  </div>
                 <div class="leer-masmodulos">
                     <a href="#!">Inscribirse</a>
                      <hr class="line3"/>
                  </div>
               </div>
            </div>
          </div>
          @endforeach
       </div>


@include('users_pages.courses.newest')
@stop
