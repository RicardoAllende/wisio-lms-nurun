@section('title')
Expertos
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.experts' , $ascription->slug) }}" class="breadcrumb">profesores</a>
@stop

@section('body')
  <div class="row pad-left3">
    <h1 class="tits">Profesores</h1>
    <div class="row hide-on-med-and-down">
      <form class="col s12" id="formSearch" name="formSearch" method="get">
        <div class="row">
          <div class="input-field col s12 l4">
            <input id="name" value="{{ $name }}" name="name" type="text" placeholder="Nombre del experto" >
          </div>
          <div class="input-field col s12 l4">
            <select name="specialty" id="specialty">
              @if($specialty != '')
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @else
                <option value="">Filtrar por especialidad</option>
              @endif
              @foreach($ascription->specialties() as $specialty)
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="input-field col s12">
            <button id="submit" class="btnAcademia waves-effect waves-light">Buscar</button>
            <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" >Limpiar</a>
            <!--<i class="material-icons prefix" id="submit">search</i>
            <input class="material-icons prefix" type="submit">-->
          </div>
        </div>
      </form>
    </div>

    <div class="row hide-on-large-only">
      <form class="col s12" id="formSearch" name="formSearch" method="get">
        <div class="row">
          <div class="col s9">
            <input id="name" value="{{ $name }}" name="name" type="text" placeholder="Nombre del experto" >
          </div>
          <div class="col s1">
            <button id="submitM" class="btnAcademia waves-effect waves-light"><i class="material-icons" >search</i></button>
          </div>
          <div class="col s1" style="margin-left:20px;">
            <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" ><i class="material-icons sufix">cached</i></a>
          </div>

          <div class="input-field col s12 l4">
            <select name="specialty" id="specialty">
              @if($specialty != '')
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @else
                <option value="">Filtrar por especialidad</option>
              @endif
              
              @foreach($ascription->specialties() as $specialty)
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @endforeach
            </select>
          </div>
          <!-- <div class="input-field col s12">
            <button id="submit" class="btnAcademia waves-effect waves-light">Buscar</button>
            <a href="{{ URL::current() }}" class="btnAcademia waves-effect waves-light" >Limpiar</a>

          </div> -->
        </div>
      </form>
    </div>

    @foreach($experts as $expert)
    <div class="col s12 m4 l3 ">
               <div class="card z-depth-0 white">
                  <div class="card-content expertoscard">
                     <div class="expertostitulo center">{{ $expert->name }}</div>
                      <div class="col s8  offset-s2 center">
                          <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                        </div>
                      <div class="col s12 expertosparticipacion">
                        <p class="upper center">Participa en:</p>
                        <ul class="browser-default ">
                          @foreach($expert->modulesFromAscription($ascription->id, $ascription->slug) as $module)
                          <li>{!! $module !!}</li>
                          @endforeach
                        </ul>
                      </div>

                    <div class="leer-masmodulos">
                      @if(isset($ascription))
                        <a href="{{ route('student.show.expert',[$ascription->slug,$expert->slug]) }}">Ver más</a>
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
  $('select').material_select();
  $('#submit','#submitM').click(function(){
    $('#formSearch').submit();
  });

  $('#name').keydown(function(e){
    if(e.which == 13) {
      $('#formSearch').submit();
    }
  });

  $('#specialty').change(function(){
    if( $('#specialty').val() != "" ){
      $('#formSearch').submit();
    }
  });

  cambiarItem("expertos");
</script>
@stop
