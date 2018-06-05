@section('title')
Evaluaciones
@stop
@extends('users_pages.master')
@section('body')
<div class="row pad-left3">
  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">Evaluaciones</h2>
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
            @if(Auth::check())
              <a href="{{ route('show.evaluation.course', [$user->ascriptionSlug(), $course->slug]) }}">Ver todo</a>
            @else
              <a href="{{ route('welcome') }}">Ver más</a>
            @endif
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
  console.log("Hola".serialize());
  cambiarItem("evaluaciones");
</script>
@stop
