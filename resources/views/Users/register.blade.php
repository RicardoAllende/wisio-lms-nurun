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
    {{--  <div class="row">
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
    </div>  --}}


<a class="btnAcademiaFloat waves-effect waves-light " id="moreData" onclick="scrollWin();"><i class="material-icons">arrow_drop_down</i></a>
  </div>



@stop

@section('extrajs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js.map"></script>
<!--<script src="/js/password_length.js"></script>-->
<script src="/js/alertify.min.js"></script>
<script>
$('#seccionPublica').hide();
$('#seccionMixta').hide();
$('#formOtraInstitucion').hide();
$('#tomadorDeDecisiones').hide();

$(document).ready(function() {
  $('select').material_select();
  $("form input:radio").change(function() {
    switch($(this).data('value')){
      case 'privada':
        $('#tomadorsi').prop('checked',false);
        $('#tomadorNo').prop('checked',false);
        $('#optcenaprece').prop('checked', false);
        $('#optOtraInstitucion').prop('checked', false);
        $('#seccionPublica').hide();
        $('#seccionMixta').hide();
        $('#institution').val('');
        $('#tomadorDeDecisiones').hide();
        $('.tomadorConsulta').removeAttr("required");
        // $('.tomadorConsulta2').removeAttr("required");
        $('.optcenaprece').removeAttr("required");
        $('#institucion').removeAttr("required");
        
      break;
      case 'publica':
        $('#tomadorsi').prop('checked',false);
        $('#tomadorNo').prop('checked',false);
        $('#optcenaprece').prop('checked', false);
        $('#optOtraInstitucion').prop('checked', false);
        $('#seccionPublica').show();
        $('#seccionMixta').hide();
        $('#formOtraInstitucion').hide();
        $('#institution').val('');
        $('#tomadorDeDecisiones').show();
        
        // $('.tomadorConsulta2').removeAttr("required");
        $('#institucion').removeAttr("required");
        $('.tomadorConsulta').prop('required',true);
        $('.optcenaprece').prop('required',true);

      break;
      case 'mixta':
        $('#tomadorsi').prop('checked',false);
        $('#tomadorNo').prop('checked',false);
        $('#optcenaprece').prop('checked', false);
        $('#optOtraInstitucion').prop('checked', false);
        $('#seccionPublica').hide();
        $('#seccionMixta').show();
        $('#institution').val('');
        $('#formOtraInstitucion').hide();
        $('#tomadorDeDecisiones').show();
        $('.tomadorConsulta').prop('required',true);
        $('.optcenaprece').attr('checked', false);
        
        $('.tomadorConsulta').removeAttr("required");
        $('.optcenaprece').removeAttr("required");
        $('#institucion').removeAttr("required");
        // $('.tomadorConsulta2').prop('required',true);

      break;
    }
  });

  $("form input:radio").click(function() {
    switch($(this).data('value')){
      case 'privada':
        $('#seccionPublica').hide();
        $('#seccionMixta').hide();
        $('#institution').val('');
        $('#tomadorDeDecisiones').hide();
        $('.tomadorConsulta').removeAttr("required");
        // $('.tomadorConsulta2').removeAttr("required");
        $('.optcenaprece').removeAttr("required");
        $('#institucion').removeAttr("required");
        
      break;
      case 'publica':
        $('#seccionPublica').show();
        $('#seccionMixta').hide();
        $('#formOtraInstitucion').hide();
        $('#institution').val('');
        $('#tomadorDeDecisiones').show();
        
        // $('.tomadorConsulta2').removeAttr("required");
        $('#institucion').removeAttr("required");
        $('.tomadorConsulta').prop('required',true);
        $('.optcenaprece').prop('required',true);

      break;
      case 'mixta':
        $('#seccionPublica').hide();
        $('#seccionMixta').show();
        $('#institution').val('');
        $('#formOtraInstitucion').hide();
        // $('#tomadorDeDecisiones').show();
        $('.tomadorConsulta').prop('required',true);

        
        $('.tomadorConsulta').removeAttr("required");
        $('.optcenaprece').removeAttr("required");
        $('#institucion').removeAttr("required");
        // $('.tomadorConsulta2').prop('required',true);

      break;
    }
  });

  $('input[type=radio][name=optcenaprece]').change(function() {
    if (this.value == '1') { // Especificación
      $('#formOtraInstitucion').show();
      $('#institution').val('');
    }else{
      $('#formOtraInstitucion').hide();
      $('#institution').val('Cenaprece');
    }
  });

});

var strength = {
    0: "Muy débil",
    1: "Débil",
    2: "Poco Débil",
    3: "Fuerte",
    4: "Muy Fuerte"
};
var password = document.getElementById('passwd');
var meter = document.getElementById('password-strength-meter');
var text = document.getElementById('password-strength-text');

if(password){
    password.addEventListener('input', function() {
        var val = password.value;
        var result = zxcvbn(val);

        // Update the password strength meter
        meter.value = result.score;

        // Update the text indicator
        if (val !== "") {
            text.innerHTML = strength[result.score];
        } else {
            text.innerHTML = "";
        }
    });
}
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
