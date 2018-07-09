@section('title')
Evaluacion
@stop

@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.list.evaluations' , $ascription->slug) }}" class="breadcrumb">Evaluaciones</a>
  <a href="" class="breadcrumb">{{ $course->name }}</a>
@stop

@section('body')

<div class="row pad-left3">
          <div class="pad-left1">
            <!-- <h3>Evaluaciones</h3> -->
            <div class="row">
              <div class="col s12 l6">
                    <h1 class="tits">EVALUACIONES</h1>
                    <p>Elija el curso del que desea consultar sus evaluaciones:</p>
                    <select name="course_slug" id="course_slug">
                        @inject('coursesController','App\Http\Controllers\Users_Pages\CoursesController')
                        @foreach($coursesController->getCourses($ascription->slug) as $courseOption)
                            <option value="{{ route('show.evaluation.course', [$ascription->slug, $courseOption->slug]) }}"> {{$courseOption->name}} </option>
                        @endforeach
                    </select>
                    @if($user->hasCertificateForCourse($course->id))
                        <a target="_blank" class="btnAcademia" href="{{ route('download.certificate.of.course', [$ascription->slug, $course->slug]) }}">Descargar Certificado</a>
                    @endif
              </div>
              <div class="col s12 l6">
                <div class="card white">
                  <div class="row">
                    <div class="col s6">
                      <h6 class="cursoev">{{ $course->name }}</h6>
                    </div>
                      <div class="col s6 right">
                        <span class="categoria-evaluacion">{{ $course->category->name }}</span>
                        <div class="iconcourseshow"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
                      </div>

                  </div>
                  <div class="card-content fontMob">
                      <div class="row center">
                          <div class="col s3"></div>
                          <div class="col s3">Total</div>
                          <div class="col s3">Avance</div>
                          <div class="col s3">Estado</div>
                      </div>
                      <div class="row center">
                          <div class="col s3 textMods">Módulo</div>
                          <div class="col s3">{{ $numModules }}</div>
                          <div class="col s3">{{ $numCompletedModules }}</div>
                          <div class="col s3">{{ $modulesAdvance }} % </div>
                      </div>
                      <div class="row center">
                          <div class="col s3 textMods">Evaluaciones</div>
                          <div class="col s3">{{ $numEvaluations }}</div>
                          <div class="col s3">{{ $completedEvaluations }}</div>
                          <div class="col s3">{{ round($evaluationsAdvance, 2) }}</div>
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
                            <h5 class="titulos-modulo">
                            {{ $evaluation->name }} <br>
                          </h5>
                            <div class="modulos">
                            @if($user->hasThisEvaluationCompleted($evaluation->id))
                                <i class="material-icons">check_box</i> EVALUACIÓN
                            @else
                                PENDIENTE
                            @endif
                            </div>
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
                <div id="references"></div>
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

<script>
    var urlDrawForm = "{{ route('draw.evaluation.form', [$ascription->slug, $courseSlug, '']) }}";
    var isEnrolled = {{ (Auth::user()->isEnrolledInCourse($course->id) == false )? 0 : 1 }};
</script>

@endsection

@section('extrajs')

<script>
  cambiarItem("evaluaciones");
  $(document).ready(function() {
    $('select').material_select();
  });
    $('#course_slug').change(function(){
        window.location.href = $(this).val();
    });
</script>
@stop
