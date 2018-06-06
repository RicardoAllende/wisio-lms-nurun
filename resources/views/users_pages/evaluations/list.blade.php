@section('title')
Evaluaciones
@stop
@extends('users_pages.master')
@section('body')
<div class="row pad-left3">
  <div class="col s6 l5">
    <hr class="line"/>
  </div>
  <div class="col s6 l7">
    <h2 class="recientes">Elija un curso para mostrar sus evaluaciones</h2>
  </div>
  @foreach($courses as $course)
  <div class="col s12 l4 ">
    <div class="card z-depth-0 white ">
       <div class="card-content mods">
          <span class="categoria-academia">{{ $course->category->name }}</span>
         <div class="iconcourse"><img src="{{ $course->getMainImgUrl() }}" class="responsive-img"></div>
          <div class="titulo-academia2"> {{ $course->name }}</div>
           <div class="modulos">{{ $course->evaluations()->count() }} evaluaciones</div>
              <div  class="moduloslista valign-wrapper">

                    <ol>
                      @foreach($course->evaluations()->slice(0,2) as $evaluation)
                        <li>{{ $evaluation->name }} </li>
                      @endforeach
                    </ol>
              </div >
          <div class="leer-masmodulos_50">
            <a href="{{ route('show.evaluation.course', [$ascription->slug, $course->slug]) }}">Ver todas las evaluaciones</a>
            <hr class="line3"/>
          </div>
       </div>
    </div>
  </div>
  @endforeach
</div>
@stop
@section('extrajs')
<script>
  cambiarItem("evaluaciones");
</script>
@stop
