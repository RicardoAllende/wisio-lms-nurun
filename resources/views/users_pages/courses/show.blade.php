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
          <?php $cont=0; ?>
          @foreach($course->modules as $module)
          <?php $cont++; ?>
          <div class="col s12 l4 ">
             <div class="card z-depth-0 white">
                  <div class="card-content collapsiblemod" data-id="1" data-module="{{ $module->id }}">
                  <div class="row valign-wrapper">
                      <div class="col s4">
                        <img src="{{ $module->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                      </div>
                      <div class="col s8">
                        <span class="titulo-academia2">
                          {{ $module->name }}
                        </span>
                          <div class="modulos">{{ Auth::user()->progressInModule($module->id) }}</div>
                      </div>
                    </div>
                  </div>

             </div>
          </div>
          @if($cont == 3 )
          <div class="col s12 content" id="mod1">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;">X</a>
              <h6 class="cursoview">Módulo 1</h6><br/>
              <h6 class="cursoview">Ajustando a la necesidad del paciente</h6><br/>
              <video width="100%" controls>
                  <source src="media/video.mp4" type="video/mp4">
              </video>
              <div>

              </div>
          </div>
          @endif

          @endforeach
          @if($course->modules->count() <= 3)
          <div class="col s12 content" id="mod1">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;">X</a>
              <h6 class="cursoview">Módulo 1</h6><br/>
              <h6 class="cursoview">Ajustando a la necesidad del paciente</h6><br/>
              <video width="100%" controls>
                  <source src="media/video.mp4" type="video/mp4">
              </video>
              <div>

              </div>
          </div>
          @endif
        </div>

@stop
@section('extrajs')
<script>
  cambiarItem("cursos");
</script>
@stop
