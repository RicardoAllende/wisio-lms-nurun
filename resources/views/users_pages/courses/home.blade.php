@section('title')
Cursos para médicos
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
@stop

@section('metadata')
  <meta name="description" content="Academia es una plataforma de Sanofi dedicada a brindar educación médica continua en línea, todos nuestros cursos están avalados. ¡Conócenos!">
  <meta name="keywords" content="Sanofi, capacitación, cursos.">
@endsection

@section('body')

          <div class="row pad-left3">
            <div class="col s6 l9">
              <hr class="line"/>
            </div>
            <div class="col s6 l3">
              <h2 class="recientes">cursos</h2>
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
                        <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'VerMas_{{ $course->slug }}'});"
                        href="{{ route('student.show.course', [$ascription->slug,$course->slug]) }}">Ver mas</a>
                      @endif
                          <hr class="line3"/>
                      </div>
                    <div class="leer-masmodulos">
                      @if(Auth::check())
                        @if(Auth::user()->isEnrolledInCourse($course->id))
                          <a href="#">Inscrito</a>
                        @else
                          <a onclick="gtag('event','Clics',{'event_category':'Home_Doctor','event_label':'Incribirse_{{ $course->slug }}'});"
                          href="{{ route('student.enrol.course', [$ascription->slug,Auth::user()->id,$course->id]) }}" >Inscribirse</a>
                        @endif
                        <hr class="line3"/>
                      @endif
                      </div>
                  </div>
                </div>
              </div>
              @endforeach
            @else
              <div class="col s12 14">
                No hay cursos disponibles para recomendarte en este momento, ve a la seccion <a href="{{ route('student.own.courses', $ascription->slug) }}">Mis cursos</a> para ver los cursos disponibles.
              </div>
            @endif

       </div>


@include('users_pages.courses.newest')
@stop

@section('extrajs')
<script>
  cambiarItem("home");
</script>
@stop
