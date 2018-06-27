@section('title')
Evaluaciones
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.list.evaluations' , $ascription->slug) }}" class="breadcrumb">Evaluaciones</a>
@stop

@section('body')
<div class="row pad-left3">
  <div class="col s6 l5">
    <hr class="line"/>
  </div>
  <div class="col s6 l7">
    <h2 class="recientes">Elija un curso para mostrar sus evaluaciones</h2>
  </div>
  @forelse($courses as $course)
  <div class="col s12 l4 ">
    <div class="card z-depth-0 white ">
       <div class="card-content mods">
          <span class="categoria-academia">{{ $course->category->name }}</span>
         <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img"></div>
          <h5 class="titulo-academia2"> {{ $course->name }}</h5>
           <div class="modulos">{{ $course->finalEvaluations()->count() }} evaluaciones</div>
              <div  class="moduloslista valign-wrapper hide-on-med-and-down">

                    <ol>
                      @foreach($course->evaluations()->slice(0,2) as $evaluation)
                        <li>{{ $evaluation->name }} </li>
                      @endforeach
                    </ol>
              </div >
          <div class="leer-masmodulos_50">
            <a href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Ver evaluaciones</a>
            <hr class="line3"/>
          </div>
       </div>
    </div>
  </div>
  @empty
<br><br><br>
  <h3>Aún no está inscrito en ningún curso</h3>
<br><br>
  @endforelse
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop
