@section('title')
Profesores
@stop
@extends('users_pages.master')

@section('metadata')
  <meta name="description" content="Conoce a los expertos que participan en cada uno de nustros cursos.">
  <meta name="keywords" content="Expertos, evaluaciones, cursos, Sanofi">
@endsection

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('student.show.experts' , $ascription->slug) }}" class="breadcrumb">profesores</a>
@stop

@section('body')
  <div class="row pad-left3">
    <h1 class="tits">Profesores</h1>
    <div class="row hide-on-med-and-down">
      <form class="col s12" id="formSearch" name="formSearch" method="get">
      {{ csrf_field() }}
        <div class="row">
          <div class="input-field col s12 l4">
            <input class="name" value="{{ $name }}" name="name" type="text" placeholder="Nombre del experto" >
          </div>
          <div class="input-field col s12 l4">
            <select id="specialty" class="specialty" name="specialty">
              @if($specialty != '')
                <option value="{{ $specialty->name }}">{{ $specialty->name }}</option>
              @else
                <option value="">Filtrar por especialidad</option>
              @endif
              @foreach($ascription->specialties() as $specialty)
                <option onclick="gtag('event','Clics',{'event_category':'Profesores','event_label':'Selecciona_{{ $specialty->name }}'});" value="{{ $specialty->name }}">{{ $specialty->name }}</option>
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
      <form class="col s12" id="formSearchM" name="formSearchM" method="get">
      {{ csrf_field() }}
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
            <select id="specialtyM" class="specialty" name="specialty">
              @if($specialty != '')
                <option value="{{ $specialty->name }}">{{ $specialty->name }}</option>
              @else
                <option value="">Filtrar por especialidad</option>
              @endif

              @foreach($ascription->specialties() as $specialty)
                <option onclick="gtag('event','Clics',{'event_category':'Profesores','event_label':'Selecciona_{{ $specialty->name }}'});" value="{{ $specialty->name }}">{{ $specialty->name }}</option>
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

    @forelse($experts as $expert)
    <div class="col s12 m6 l3 ">
        <div class="card z-depth-0 white">
          <div class="card-content expertoscard">
              <div class="expertostitulo center">{{ $expert->name }}</div>
              <div class="col s8  offset-s2 center padtop15">
                  <img src="{{ $expert->getMainImgUrl() }}" alt="" class="circle responsive-img imgExperts"> <!-- notice the "circle" class -->
                </div>
              <div class="col s12 expertosparticipacion padtop15">
                <p class="upper center">Participa en:</p>
                <ul class="browser-default ">
                  @foreach($expert->modulesFromAscription($ascription->id, $ascription->slug) as $module)
                  <li>{!! $module !!}</li>
                  @endforeach
                </ul>
              </div>

            <div class="leer-masmodulos">
              @if(isset($ascription))
                <a onclick="gtag('event','Clics',{'event_category':'Profesores','event_label':'VerMas_{{ $expert->slug }}'});" href="{{ route('student.show.expert',[$ascription->slug,$expert->slug]) }}">Ver más</a>
              @endif
                <hr class="line3"/>
              </div>
          </div>
        </div>
    </div>
    @empty
    <h2 class="recientes">No existen profesores que coincidan con su criterio de búsqueda</h2>
    @endforelse
  </div>
@stop

@section('extrajs')
<script>
    $(document).ready(function(){
      $('select').material_select();
      $('#submit').click(function(){
        $('#formSearch').submit();
      });

      $('#submitM').click(function(){
        $('#formSearchM').submit();
      });

      $('.name').keydown(function(e){
        if(e.which == 13) {
          $('#formSearch').submit();
        }
      });

      $('#specialty').change(function(){
        var label = "Selecciona_" + $(this).val();
        gtag('event','Clics',{'event_category':'Profesores','event_label': label });
        $('#formSearch').submit();
      });

      $('#specialtyM').change(function(){
        var label = "Selecciona_" + $(this).val();
        gtag('event','Clics',{'event_category':'Profesores','event_label': label });
        $('#formSearchM').submit();
      });

      $('.specialty').change(function(){

      });

      cambiarItem("expertos");
    });

</script>
@stop
