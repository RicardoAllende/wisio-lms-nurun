@section('title')
Curso {{ $course->name }}
@stop
@extends('users_pages.master')
@section('body')

<div class="row pad-left3">
          <div class="pad-left1">
            <h5 class="cursoview">{{ $course->name }}</h5>
            <span class="categoria-modulos">{{ $course->categories->first()->name }}</span>
            <span class="icon-cardiologia iconmodule"></span>
            </div>

          <div class="col s6 l9">
             <hr class="line"/>
          </div>
          <div class="col s6 l3">
             <h2 class="recientes">Módulos</h2>
          </div>
          @foreach($course->modules as $module)
          <div class="col s12 l4 ">
             <div class="card z-depth-0 white">
                  <div class="card-content collapsiblemod" data-id="1">
                  <div class="row valign-wrapper">
                      <div class="col s4">
                        <img src="{{ $module->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                      </div>
                      <div class="col s8">
                        <span class="titulo-academia2">
                          {{ $module->name }}
                        </span>
                          <div class="modulos">Pendiente</div>
                      </div>
                    </div>
                  </div>

             </div>
          </div>
          @endforeach
        </div>

@stop
