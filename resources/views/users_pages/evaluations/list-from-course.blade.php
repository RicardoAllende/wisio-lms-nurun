@section('title')
Evaluacion
@stop
@extends('users_pages.master')
@section('extracss')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('body')

<div class="row pad-left3">
          <div class="pad-left1">
            <!-- <h3>Evaluaciones</h3> -->
            <div class="row">
              <div class="col s6 offset-s6">
                <div class="card white">
                  <div class="row">
                      <h6 class="cursoev">Endocrinología</h6>
                      <span class="categoria-evaluacion">Cardiología </span>
                      <div class="iconcourseshow"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
                  </div>
                  <div class="card-content">
                      <div class="row center">
                          <div class="col s3"></div>
                          <div class="col s3">Total</div>
                          <div class="col s3">Avance</div>
                          <div class="col s3">Estado</div>
                      </div>
                      <div class="row center">
                          <div class="col s3">Módulo</div>
                          <div class="col s3">9</div>
                          <div class="col s3">2</div>
                          <div class="col s3">21%</div>
                      </div>
                      <div class="row center">
                          <div class="col s3">Evaluaciones</div>
                          <div class="col s3">9</div>
                          <div class="col s3">2</div>
                          <div class="col s3">6.5</div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col s6 l9">
             <hr class="line"/>
          </div>
          <div class="col s6 l3">
             <h2 class="recientes">Evaluaciones</h2>
          </div>
          <?php $cont=0; $mod=0; ?>
          @foreach($evaluations as $evaluation)
            <?php $cont++; ?>
            <div class="col s12 l4 ">
                <div class="card z-depth-0 white">
                    <div class="card-content collapsiblemod" data-id="{{ $mod+1 }}" data-eval="{{ $evaluation->id }}">
                    <div class="row valign-wrapper">
                        <div class="col s4">
                            <img src="{{ $evaluation->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                        <div class="col s8">
                            <span class="titulo-academia2">
                            {{ $evaluation->name }}
                            </span>
                            <div class="modulos">{{ Auth::user()->progressInModule($evaluation->id) }}</div>
                        </div>
                        </div>
                    </div>

                </div>
            </div>
            @if($cont == 3 )
            <?php $cont = 0; $mod++; ?>
            <div class="col s12 content" id="mod{{ $mod }}">
                <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
                <h6 class="cursoview"></h6><br/>
                <h6 class="cursoview" id="name_module"></h6><br/>
                <!-- start modal content -->
                <div id="content" style="min-height: 400px;">







                </div><!-- end modal content -->
                <div id="references">

                </div>
            </div>
            @endif

          @endforeach
          @if($course->modules->count() <= 3)
          <div class="col s12 content" id="mod1">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
              <h6 class="cursoview">Módulo</h6><br/>
              <h6 class="cursoview" id="name_module"></h6><br/>
              <div id="content">

              </div>
              <div id="references">

              </div>
          </div>
          @endif

          @if(($evaluations->count()%3) > 0)
          <?php $cont = 0; $mod++; ?>
          <div class="col s12 content" id="mod{{ $mod }}">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
              <h6 class="cursoview"></h6><br/>
              <h6 class="cursoview" id="name_module"></h6><br/>
              <div id="content" style="min-height: 400px;"><!-- start modal content -->
              </div><!-- end modal content -->
              <div id="references">

              </div>
          </div>
          @endif
        </div>


@stop
@section('extrajs')
<style>
.circle-selected, .circle-dot:hover {
  background-color: #8F6EAA;
}
.purple-text{
  color: #8F6EAA;
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

<script>
  cambiarItem("evaluaciones");
</script>
@stop
