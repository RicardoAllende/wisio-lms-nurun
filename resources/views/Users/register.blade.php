@section('title')
Registro
@stop
@extends('users_pages.master')
@section('breadcrumbs')
  <a href="{{ route('student.home', 'invitado') }}" class="breadcrumb">Inicio</a>
  <a class="breadcrumb">Registro</a>
@stop
@section('body')

<div class="row pad-left3">
  <div class="col s3">
     <hr class="line"/>
  </div>
  <div class="col s9 right">
     <h2 class="recientes">¿Te interesa probar WisioLMS? <br> Cuéntanos más sobre ti.</h2>
  </div>
</div>
<div class="row">
  {!! Form::open(['route' => 'public.register', 'class'=>'form-horizontal col s12','method' => 'post']) !!}
  <div class="row">
      <div class="reg col s12 l5 offset-l2">
        {{--  <h6 class="upscase center">Nombre de la empresa</h6>  --}}
        {!! Form::label('company', 'Nombre de la empresa:' )!!}
        {!! Form::text('company',null,['class'=>'','placeholder'=>'Nombre de la empresa', 'required' => '', 'maxlength' =>"50" ]) !!}
        {{--  <span class="smalltext">Servirá como nombre de usuario.</span><br><br>  --}}

      </div>
  </div>
  <div class="row">
      <div class="reg col s12 l5 offset-l2">
        {{--  <h6 class="upscase center">Url de la empresa</h6>  --}}
        {!! Form::label('url', 'Url de la empresa:' )!!}
        {!! Form::text('url',null,['class'=>'','placeholder'=>'Url de la empresa', 'maxlength' =>"50" ]) !!}
        {{--  <span class="smalltext">Servirá como nombre de usuario.</span><br><br>  --}}

      </div>
  </div>
  <div class="row">
      <div class="reg col s12 l5 offset-l2">
        {{--  <h6 class="upscase center">Nombre</h6>  --}}
        {!! Form::label('name', 'Nombre:' )!!}
        {!! Form::text('name',null,['class'=>'','placeholder'=>'Nombre', 'required' => '', 'maxlength' =>"50" ]) !!}
        {{--  <span class="smalltext">Servirá como nombre de usuario.</span><br><br>  --}}

      </div>
  </div>
  <div class="row">
      <div class="reg col s12 l5 offset-l2">
        {{--  <h6 class="upscase center">Correo electrónico de contacto</h6>  --}}
        {!! Form::label('email', 'Correo Electrónico de contacto:' )!!}
        {!! Form::email('email',null,['class'=>'','placeholder'=>'Correo electrónico de contacto', 'required' => '', 'maxlength' =>"50" ]) !!}
        {{--  <span class="smalltext">Servirá como nombre de usuario.</span><br><br>  --}}

      </div>
  </div>
  <div class="row">
      <div class="reg col s12 l5 offset-l2">
        {{--  <h6 class="upscase center">Teléfono de contacto</h6>  --}}
        {!! Form::label('phone', 'Teléfono de contacto:' )!!}
        {!! Form::text('phone',null,['class'=>'','placeholder'=>'Teléfono de contacto', 'maxlength' =>"50" ]) !!}
        {{--  <span class="smalltext">Servirá como nombre de usuario.</span><br><br>  --}}

      </div>
  </div>
  {{--  <div class="row pad-left3">
    <div class="col s6 l9">
       <hr class="line"/>
    </div>
    <div class="col s6 l3">
       <h2 class="recientes">Datos personales</h2>
    </div>

  </div>  --}}

    {{--  <div class="row pad-left3">
      <div class="col s6 l9">
         <hr class="line"/>
      </div>
      <div class="col s6 l3">
         <h2 class="recientes">Declaraciones</h2>
      </div>

    </div>  --}}

    <br>
    <div class="row">
      <br>

        <div class="reg col s12 l5 offset-l2">
          <div class="reg col s12">
            <input type="checkbox" id="test5" required />
            <label for="test5">Acepto recibir correos acerca de wisiolms y subitus.</a></label>
          </div>
        </div>

    </div>
    <div class="row">
      <div class="col s12 l5 offset-l2 center">
            @if(isset($ascription))
                <input type="hidden" name="seccion" value="{{ $ascription->slug }}">
            @endif
            @if(isset($code))
                <input type="hidden" name="refered_code" value="{{ $code }}">
            @endif
        <input type="submit" onclick="gtag('event','Clics',{'event_category':'Ingreso_registro','event_label':'Registro_registrarse'});" class="btnAcademia" value="Registrarse"  id="btnSubmit" >

        {!! Form::close() !!}
      </div>
    </div>


<a class="btnAcademiaFloat waves-effect waves-light " id="moreData" onclick="scrollWin();"><i class="material-icons">arrow_drop_down</i></a>
  </div>



@stop

@section('extrajs')
<!--<script src="/js/password_length.js"></script>-->
<script src="/js/alertify.min.js"></script>
<script>
$('#seccionPublica').hide();
$('#seccionMixta').hide();
$('#formOtraInstitucion').hide();
$('#tomadorDeDecisiones').hide();

$(document).ready(function() {
    $('select').material_select();
});

function scrollWin() {

  if($(document).height() > ($(window).height() + $(window).scrollTop() + 200)){
    //console.log($(document).height+" - "+$(window).height() + $(window).scrollTop)
    window.scrollBy(0, 300);
    if($(document).height() <= ($(window).height() + $(window).scrollTop() + 200)){
      $('#moreData').hide();
    }
  } else {
    $('#moreData').hide();
    console.log("llego al final")
  }

}
</script>
@stop
@section('extracss')
  <link rel="stylesheet" href="/css/alertify.core.css">
  <link rel="stylesheet" href="/css/alertify.bootstrap.css">
  <link rel="stylesheet" href="/css/alertify.default.css">
  {{--  <link rel="stylesheet" href="/css/hsimp.jquery.css">  --}}
@endsection
