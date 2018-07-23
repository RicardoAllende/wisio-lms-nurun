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
  <div class="col s6 l9">
     <hr class="line"/>
  </div>
  <div class="col s6 l3">
     <h2 class="recientes">Regístrese</h2>
  </div>
</div>
<div class="row">
  {!! Form::open(['route' => 'public.register', 'class'=>'form-horizontal col s12','method' => 'post']) !!}
  <div class="row">
    <div class="reg col s12 l5 offset-l2">
      <h6 class="upscase center">Usuario y contraseña</h6>
      {!! Form::label('email', 'Correo Electrónico:' )!!}
      {!! Form::email('email',null,['class'=>'','placeholder'=>'Correo electrónico personal', 'required' => '', 'id' => 'email', 'maxlength' =>"50" ]) !!}
      <span class="smalltext">Servirá como nombre de usuario.</span><br><br>
      {!! Form::label('password', 'Contraseña:' )!!}
      <input type="password" name="password" id="passwd" placeholder="Contraseña" required>
      <meter max="4" id="password-strength-meter" style="width:100%;"></meter>
      <span class="smalltextright" id="password-strength-text"></span><br>
      <span class="smalltext">Su contraseña debe contener al menos:<br>
        -Una mayúscula &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Un caracter Especialidad <br>
        -Una minúscula &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -8 caracteres minimo<br>
        -Un numero

      </span><br><br>
    </div>
  </div>
  <div class="row pad-left3">
    <div class="col s6 l9">
       <hr class="line"/>
    </div>
    <div class="col s6 l3">
       <h2 class="recientes">Datos personales</h2>
    </div>

  </div>
  <div class="row">


    <div class="reg col s12 l5 offset-l2">
      {!! Form::label('firstname', 'Nombre:',['for'=>'firstname']); !!}
      {!! Form::text('firstname',null,['class'=>'validate','placeholder'=>'Nombre', 'required'=>'', 'id' => 'nombre', 'pattern' => "[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50' ]) !!}
      <div class="row">
        <div class="reg col s12 l6">
          {!! Form::label('paterno', 'Apellido paterno:',['for'=>'paterno']); !!}
          {!! Form::text('paterno',null,['class'=>'validate','placeholder'=>'Apellidos', 'required'=>'', 'id'=> 'paterno', 'pattern' => "[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50' ]) !!}

        </div>
        <div class="reg col s12 l6">
          {!! Form::label('materno', 'Apellido materno:',['for'=>'paterno']); !!}
          {!! Form::text('materno',null,['class'=>'validate','placeholder'=>'Apellidos', 'required'=>'', 'id'=> 'materno', 'pattern' => "[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50' ]) !!}

        </div>
      </div>
      <div class="row">
        <h6 class="upscase">Sexo</h6>
        <div class="reg col s12 l6">
          <input class="with-gap" name="gender" type="radio" id="hombre" value="1" required />
          <label for="hombre">Hombre</label>

        </div>
        <div class="reg col s12 l6">
          <input class="with-gap" name="gender" type="radio" id="mujer" value="2" required />
          <label for="mujer">Mujer</label>
        </div>
      </div>
    </div>


  </div>
  <div class="row pad-left3">
    <div class="col s6 l9">
       <hr class="line"/>
    </div>
    <div class="col s6 l3">
       <h2 class="recientes">Práctica profesional</h2>
    </div>

  </div>
  <div class="row">
    <br>

      <div class="reg col s12 l5 offset-l2">

        <div class="reg col s12 l6">
          {!! Form::label('professional_license', 'Cédula profesional:' )!!}
          {!! Form::text('professional_license',null,['class'=>'','placeholder'=>'7 dígitos', 'required' => '', 'id' => 'professional_license', 'pattern' => "[0-9]{1,10}", 'title'=> "Únicamente números", 'maxlength' => '10' ]) !!}
          <span class="smalltext">Su cedula debe tener 7 digitos o más:<br>
            -Ej. 0045727 ó 4521597

          </span><br><br>
        </div>
        <div class="reg col s12 l6">
          {!! Form::label('specialty_id', 'Especialidad:',['class'=>'']); !!}
          <select name="specialty_id" id="specialty_id" required class="">
            @inject('specialtiesController','App\Http\Controllers\AdminControllers\SpecialtiesController')
            @foreach($specialtiesController->getAllSpecialties() as $specialty)
              <option value="{{$specialty->id}}"> {{$specialty->name}} </option>
            @endforeach
          </select>

        </div>
        <br><br><br><br>
        <div class="col s12 white consulta">
          <h6 class="upscase">Tipo de consulta</h6><br>
          <div class="reg col s6">
            <input class="with-gap" name="consultation_type" required type="radio" value="1" data-value="privada" id="privado" />
            <label for="privado">Privado</label><br><br>
            <input class="with-gap" name="consultation_type" required type="radio" value="2" data-value="publica" id="publica" />
            <label for="publica">Pública</label><br><br>
            <input class="with-gap" name="consultation_type" required type="radio" value="3" data-value="mixta" id="mixta" />
            <label for="mixta">Mixta</label><br><br>
          </div>
          <div class="reg col s6">
            Acceso a:<br>
            <span class="typeCon">
            </span>
          </div>

        </div>
        <div class="col s6">
          {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
          {!! Form::text('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '', 'pattern' => "[0-9]{7,15}", 'title'=> "Únicamente números", 'maxlength' => '15']) !!}
        </div>
        <div class="col s6">
          {!! Form::label('state_id', 'Estado:',['class'=>'control-label col-sm-2']); !!}
            <select name="state_id" id="state_id" required>
                @inject('usersController','App\Http\Controllers\Users_Pages\UserController')
                @foreach($usersController->getAllStates() as $state)
                    <option value="{{$state->id}}"> {{$state->name}} </option>
                @endforeach
            </select>
        </div>



      </div>
    </div>

    <div class="row pad-left3">
      <div class="col s6 l9">
         <hr class="line"/>
      </div>
      <div class="col s6 l3">
         <h2 class="recientes">Declaraciones</h2>
      </div>

    </div>

    <br>
    <div class="row">
      <br>

        <div class="reg col s12 l5 offset-l2">

          <div class="reg col s12 l6">
            <input type="checkbox" id="test5" required />
            <label for="test5">Conozco y acepto los <a href="#">Términos de uso </a></label>
          </div>
          <div class="reg col s12 l6">
            <input type="checkbox" id="test6" required />
            <label for="test6">Conozco y acepto la <a href="#">Política de privacidad </a></label>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js.map"></script>
<!--<script src="/js/password_length.js"></script>-->
<script src="/js/alertify.min.js"></script>
<script>
$(document).ready(function() {
  $('select').material_select();
  $("form input:radio").click(function() {
    switch($(this).data('value')){
      case 'privada':
        $('.typeCon').html('- Blog para médicos <br>- Cursos en línea <br>- Calendario de eventos <br>- Materiales de apoyo en consulta<br>- Muestras médicas en casa <br>- Vademecum Sanofi <br>');
      break;
      case 'publica':
        $('.typeCon').html('- Cursos en línea <br>- Materiales de apoyo en consulta');
      break;
      case 'mixta':
        $('.typeCon').html('- Cursos en línea <br>- Materiales de apoyo en consulta');
      break;
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
  <link rel="stylesheet" href="/css/hsimp.jquery.css">
  <style>
    meter {
        /* Reset the default appearance */
        margin: 0 auto 1em;
        width: 100%;
        height: .5em;

        /* Applicable only to Firefox */
        background: none;
        background-color: rgba(0,0,0,0.1);
    }

    meter::-webkit-meter-bar {
        background: none;
        background-color: rgba(0,0,0,0.1);
    }

    meter[value="0"]::-webkit-meter-optimum-value,
    meter[value="1"]::-webkit-meter-optimum-value { background: #f9f9f9; }
    meter[value="2"]::-webkit-meter-optimum-value { background: #f3f4f4; }
    meter[value="3"]::-webkit-meter-optimum-value { background: #c7b1d4; }
    meter[value="4"]::-webkit-meter-optimum-value { background: #8f6eaa; }

    meter[value="1"]::-moz-meter-bar,
    meter[value="1"]::-moz-meter-bar { background: #f9f9f9; }
    meter[value="2"]::-moz-meter-bar { background: #f3f4f4; }
    meter[value="3"]::-moz-meter-bar { background: #c7b1d4; }
    meter[value="4"]::-moz-meter-bar { background: #8f6eaa; }

    .feedback {
        color: #9ab;
        font-size: 90%;
        padding: 0 .25em;
        font-family: Courgette, cursive;
        margin-top: 1em;
    }

    meter::-webkit-meter-optimum-value {
      transition: width .4s ease-out;
    }
  </style>
@endsection
