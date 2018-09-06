@section('title')
Cursos
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.own.courses' , $ascription->slug) }}" class="breadcrumb">Cursos</a>
@stop

@section('body')
<div class="row pad-left3">

  <div class="row hide-on-med-and-down">
    <form class="col s12 l4" id="searchForm">
    {{ csrf_field() }}
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix" >search</i>
          <input id="search" name="s" value="{{ $search }}" type="text" placeholder="Nombre del curso o especialidad">
          <!-- <div class="search-wrapper card">
            <input id="search" type="text" placeholder="Nombre del curso"><i class="material-icons">search</i>
          </div> -->

          <!--<i class="material-icons" id="sendform">search</i>
          <i class="material-icons sufix">subdirectory_arrow_left</i>-->
        </div>
      </div>
    <br>

    <div class="col s12">
      <input type="submit" id="sendform" class="btnAcademia waves-effect waves-light" value="Buscar" >
      <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" >Limpiar</a>
    </div>
    </form>

  </div>

  <div class="row hide-on-large-only">
    <form class="col s12 l4" id="searchForm">
    {{ csrf_field() }}
      <div class="row">
        <div class="col s8">
          <!-- <i class="material-icons prefix" >search</i> -->
          <input id="search" name="s" value="{{ $search }}" type="text" placeholder="Nombre del curso o especialidad">


        </div>
        <div class="col s1">
          <button id="sendformM" class="btnAcademia waves-effect waves-light"><i class="material-icons" >search</i></button>
        </div>
        <div class="col s1" style="margin-left:20px;">
          <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" ><i class="material-icons sufix">cached</i></a>
        </div>
        <!-- <i class="material-icons sufix">subdirectory_arrow_left</i> -->
      </div>
    </form><br>

    <!-- <div class="col s12">
      <button id="sendform" class="btnAcademia waves-effect waves-light">Buscar</button>
      <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" >Limpiar</a>
    </div> -->


  </div>

  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">cursos</h2>
  </div>
  @foreach($diplomas as $diploma)
  <div class="col s6 l4 ">
    <div class="card z-depth-0 white " style="background-color: #f3e5f5;">
       <div class="card-content mods" style="background-color: #f3e5f5;">
          <span class="categoria-academia">Diplomado</span>
         <div class="iconcourse"><img src="{{ $diploma->getMainImgUrl() }}" class="responsive-img imgMods"></div>
          <h5 class="titulo-academia2"> {{ $diploma->name }}</h5>
           <div class="modulos"></div>
              <div  class="moduloslista valign-wrapper hide-on-med-and-down">
                {{ $diploma->description }}
              </div >
          <div class="leer-masmodulos_50">
              <a href="{{ route('show.diploma', [$ascription->slug,$diploma->slug]) }}">Ver todo</a>
              <hr class="line3"/>
          </div>
       </div>
    </div>
  </div>
  @endforeach
  @forelse($courses as $course)
  <div class="col s6 l4 ">
    <div class="card z-depth-0 white ">
       <div class="card-content mods">
          <span class="categoria-academia">{{ $course->category->name }}</span>
         <div class="iconcourse"><img src="{{ $course->category->getMainImgUrl() }}" class="responsive-img imgMods"></div>
          <h5 class="titulo-academia2"> {{ $course->name }}</h5>
           <div class="modulos">{{ $course->modules->count() }} módulos</div>
              <div  class="moduloslista valign-wrapper hide-on-med-and-down">

                    <ol>
                      @foreach($course->modules->slice(0,3) as $module)
                        <li>{{ $module->name }} </li>
                      @endforeach
                    </ol>
              </div >
          <div class="leer-masmodulos_50">
            @if(Auth::check())
              <a href="{{ route('student.show.course', [$ascription->slug,$course->slug]) }}">Ver todo</a>
            @else
              <a href="{{ route('welcome') }}">Ver más</a>
            @endif
              <hr class="line3"/>
          </div>
       </div>
    </div>
  </div>
  @empty
    @if(isset($_GET['s']))
      <h6>No existen cursos que coincidan con su búsqueda</h6>
    @else
      <h6>Aún no está inscrito a ningún curso</h6>
    @endif
  @endforelse
</div>
@php $courses = $ascription->courses;  @endphp
@include('users_pages.courses.newest')
@stop
@section('extrajs')
<script>
$("#sendform","#sendformM").click(function(){
  if($('#search').val() != ''){
    $('#searchForm').submit();
  }

});
  cambiarItem("cursos");
</script>
@stop
