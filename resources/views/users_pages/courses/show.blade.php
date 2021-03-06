@section('title')
Curso {{ $course->name }}
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.own.courses' , $ascription->slug) }}" class="breadcrumb">Cursos</a>
  <a href="" class="breadcrumb">{{ $course->name }}</a>
@stop

@section('body')
  @include('users_pages.courses.modal')
  @include('users_pages.courses.modalEvDiag')
  @include('users_pages.courses.modalInscripcion')
  @if($course->name != 'Farmacoeconomía')
    @include('users_pages.courses.credits-modal')
  @endif  
  <div class="row pad-left3">
          <div class="pad-left1">
            <h2 class="cursoview">{{ $course->name }}</h2>
            <span class="categoria-modulos">{{ $course->category->name }}</span>
            <div class="iconcourseshow"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"/></div>
          </div>

          <div class="col s6 l9">
            <hr class="line"/>
          </div>
          <div class="col s6 l3 adjust-landscape">
            <h2 class="recientes">Módulos</h2>
          </div>
          @if( ! Auth::check() ) <?php /* Section for guests */ ?>
            <div class="row">
            @foreach($course->modules as $module)
              <div class="col s12 l4 adjust-list">
                <div class="card z-depth-0 white">
                    <div class="card-content modOut">
                      <div class="row valign-wrapper">
                          <div class="col s4">
                            <img src="{{ $module->getMainImgUrl() }}" alt="" class="circle moduleimg hide-on-med-and-down">
                            <img src="{{ $module->getMainImgUrl() }}" alt="" class="circle moduleimgM hide-on-large-only">
                          </div>
                          <div class="col s8">
                            <h5 class="titulos-modulo">
                              <a href="#modal1" style="color: #8F6EAA;" class="modal-trigger" onclick="gtag('event','Clics',{'event_category':'Home','event_label':'Ingreso_Registro'});">{{ $module->name }}</a>
                            </h5>
                          </div>
                        </div>
                    </div>
                </div>
              </div>


            @endforeach <?php /* End section for guests */ ?>
          </div>
          @else
          <?php $cont=0; $mod=0; ?>
          @foreach($course->modules as $module)
          <?php $cont++; ?>
          <div class="col s12 l4 adjust-list">
              <div class="card z-depth-0 white">
                  <div @if($user->moduleInList($course, $module->id) ) class="card-content collapsiblemod" @else class="card-content collapsiblemod-disabled" data-disabled="1" @endif
                     id="modulo{{ $module->id }}" data-id="{{ $mod+1 }}" data-module="{{ $module->id }}"
                   data-eva="{{ $module->hasDiagnosticEvaluationForUser() }}"
                   @if($module->hasDiagnosticEvaluation())
                     <?php $evaluation = $module->diagnosticEvaluations->first(); ?>
                     @if($evaluation->hasQuestions())
                       data-evi="{{ $evaluation->id }}"
                     @endif
                   @endif
                   @if($module->hasFinalEvaluationForUser($user))
                   data-final="1" data-final-i="{{ $module->id }}"
                   @endif
                   >
                  <div class="row valign-wrapper">
                      <div class="col s4">
                        <img src="{{ $module->getMainImgUrl() }}" alt=""
                          @if($user->moduleInList($course, $module->id) ) class="circle moduleimg hide-on-med-and-down" @else class="circle moduleimg-disabled hide-on-med-and-down" @endif
                         >
                        <img src="{{ $module->getMainImgUrl() }}" alt=""
                          @if($user->moduleInList($course, $module->id) ) class="circle moduleimgM hide-on-large-only" @else class="circle moduleimgM hide-on-large-only" @endif
                        >
                      </div>
                      <div class="col s8">
                        <h5 class="titulos-modulo">
                          {{ $module->name }}
                        </h5>
                          <div class="modulos">{!! Auth::user()->progressInModule($module->id) !!}</div>
                      </div>
                    </div>
                  </div>
             </div>
          </div>
          @if($cont == 3 )
          <?php $cont = 0; $mod++; ?>
          <div class="col s12 content module-content" id="mod{{ $mod }}">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
              <h2 class="cursoview">Módulo</h2>
              <h2 class="cursoview" id="name_module"></h2><br/>
              <div class="chip" >
                Video - de -
              </div>
              <div id="pag_vid" class="video_pag paginator" style="display: none;">    
                <ul style="display: inline;">
                   <li class="prev-next prev_button" id="prev_b" style="padding: 6px;"> &lt;&lt; </li>
                   <li class="prev-next next_button" id="next_b" style="padding: 6px 8px;"> &gt;&gt; </li>
                </ul>
              </div>
              <div id="content">

              </div>
              <h5 class="titulos-modulo" id="referencesTitle">
                Referencias
              </h5>
              <div id="references">

              </div>
          </div>
          @endif

          @endforeach
          @if($course->modules()->count() <= 3)
          <div class="col s12 content module-content" id="mod1">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
              <h2 class="cursoview">Módulo</h2>
              <h2 class="cursoview" id="name_module"></h2><br/>
              <div class="chip">
                Video - de -
              </div>
              <div id="pag_vid" class="video_pag paginator" style="display: none;">    
                <ul style="display: inline;">
                   <li class="prev-next prev_button" id="prev_b" style="padding: 6px;"> &lt;&lt; </li>
                   <li class="prev-next next_button" id="next_b" style="padding: 6px 8px;"> &gt;&gt; </li>
                </ul>
              </div>
              <div id="content">

              </div>
              <h5 class="titulos-modulo">
                Referencias
              </h5>
              <div id="references">

              </div>
          </div>
          @endif
          @if(($course->modules()->count()%3) > 0)
          <?php $cont = 0; $mod++; ?>
          <div class="col s12 content module-content" id="mod{{ $mod }}">
              <a class="waves-effect waves-light btn-small cerrar" style="color:white !important;" onclick="closeModule();">X</a>
              <h2 class="cursoview">Módulo</h2>
              <h2 class="cursoview" id="name_module"></h2><br/>
              <div class="chip">
                Video - de -
              </div>
              <div id="pag_vid" class="video_pag paginator" style="display: none;">    
                <ul style="display: inline;">
                   <li class="prev-next prev_button" id="prev_b" style="padding: 6px;"> &lt;&lt; </li>
                   <li class="prev-next next_button" id="next_b" style="padding: 6px 8px;"> &gt;&gt; </li>
                </ul>
              </div>

              <div id="content">

              </div>
              <h5 class="titulos-modulo">
                Referencias
              </h5>
              <div id="references">

              </div>
          </div>
          @endif


    @endif <?php /* End if auth */ ?>



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
    @if( isset($user) )
      var isEnrolled = {{ ($user->isEnrolledInCourse($course->id) == false )? 0 : 1 }};
      var hasFinished = {{ ($user->hasCourseComplete($course->id)) ? 1 : 0 }};
      var urlFinal = "{{ route('show.evaluation', [$ascription->slug, $course->slug, '*']) }}";
    @endif
  </script>
@stop

@section('extrajs')
<script src="/js/plugins/tincan/tincan.js" type="text/javascript"></script>
<script src="/js/js_users_pages/tincanConnector.js" type="text/javascript"></script>
<script>
    var urlDrawForm = "{{ route('draw.evaluation.form', [$ascription->slug, $course->slug, '']) }}";
    @if(isset($msg))
      @if($msg != '')
        Materialize.toast( "{{ $msg }}" ,4000,'acept');
      @endif
    @endif
    cambiarItem("cursos");
    $('.modal').modal({
      dismissible: false
    });

    $('.chips').material_chip();

    @if(Auth::check())
      var student_data = {
        name: '{{ Auth::user()->full_name }}',
        email: '{{ Auth::user()->email }}'
      };

      var myAgent = new TinCan.Agent (
        {
            mbox: "mailto:" + student_data.email
        }
      );
      @if($user->isEnrolledInCourse($course->id))
        @if( ! $refresh )
          $(document).ready(function() {
            $('#creditsModal').modal('open');
            $('#creditsModal').width('70%');
            $('#creditsModal').height('70%');
            $('#creditsModal').css('overflow', 'hidden');
            setTimeout(function(){
              $('#creditsModal').modal('close');
            }, 4000);
          });
        @endif
      @endif
    @endif


</script>
@stop
