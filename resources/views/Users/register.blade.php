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
      {!! Form::label('em', 'Correo Electrónico:' )!!}
      {!! Form::text('email',null,['class'=>'','placeholder'=>'Correo electrónico personal', 'required' => '', 'id' => 'email' ]) !!}
      <span class="smalltext">Servirá como nombre de usuario.</span><br><br>
      {!! Form::label('password', 'Contraseña:' )!!}
      <input type="password" name="password" id="passwd" placeholder="Contraseña" required>
      <meter max="4" id="password-strength-meter" style="width:100%;"></meter>
      <p id="password-strength-text"></p>
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
      {!! Form::text('firstname',null,['class'=>'validate','placeholder'=>'Nombre', 'id' => 'nombre']) !!}
      <div class="row">
        <div class="reg col s12 l6">
          {!! Form::label('paterno', 'Apellido paterno:',['for'=>'paterno']); !!}
          {!! Form::text('paterno',null,['class'=>'validate','placeholder'=>'Apellidos', 'id'=> 'paterno' ]) !!}

        </div>
        <div class="reg col s12 l6">
          {!! Form::label('materno', 'Apellido materno:',['for'=>'paterno']); !!}
          {!! Form::text('materno',null,['class'=>'validate','placeholder'=>'Apellidos', 'id'=> 'materno' ]) !!}

        </div>
      </div>
      <div class="row">
        <h6 class="upscase">Sexo</h6>
        <div class="reg col s12 l6">
          <input class="with-gap" name="gender" type="radio" id="hombre" value="m"  />
          <label for="hombre">Hombre</label>

        </div>
        <div class="reg col s12 l6">
          <input class="with-gap" name="gender" type="radio" id="mujer" value="f" />
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
          {!! Form::label('cedula', 'Cédula:' )!!}
          {!! Form::number('cedula',null,['class'=>'','placeholder'=>'Cédula profesional; si su cédula profesional tiene menos de 7 dígitos, agrege 0 hasta completar los 7 números', 'required' => '', 'id' => 'cedula' ]) !!}
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
            <input class="with-gap" name="consultation_type" type="radio" value="Privada" id="privado" />
            <label for="privado">Privado</label><br><br>
            <input class="with-gap" name="consultation_type" type="radio" value="Pública" id="publica" />
            <label for="publica">Pública</label><br><br>
            <input class="with-gap" name="consultation_type" type="radio" value="Mixta" id="mixta" />
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
          {!! Form::number('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '']) !!}
        </div>
        <div class="col s6">
          {!! Form::label('state_id', 'Estado:',['class'=>'control-label col-sm-2']); !!}
            <select name="state_id" id="state_id" required>
                <option value="">Seleccione un estado</option>
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
            <input type="checkbox" id="test5" />
            <label for="test5">Conozco y acepto los <a href="#">Términos de uso </a></label>
          </div>
          <div class="reg col s12 l6">
            <input type="checkbox" id="test6" />
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
                <input type="hidden" name="code" value="{{ $code }}">
            @endif
        <input type="submit" class="btnAcademia" value="Registrarse"  id="btnSubmit" >
        {!! Form::close() !!}
      </div>
    </div>



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
    switch($(this).val()){
      case 'Privada':
        $('.typeCon').html('- Blog para médicos <br>- Cursos en línea <br>- Calendario de eventos <br>- Materiales de apoyo en consulta<br>- Muestras médicas en casa <br>- Vademecum Sanofi <br>');
      break;
      case 'Pública':
        $('.typeCon').html('- Cursos en línea <br>- Materiales de apoyo en consulta');
      break;
      case 'Mixta':
        $('.typeCon').html('- Cursos en línea <br>- Materiales de apoyo en consulta');
      break;
    }
  });
});

var strength = {
    0: "Insegura",
    1: "Contraseña insegura",
    2: "Contraseña poco segura",
    3: "Contraseña segura",
    4: "Contraseña muy segura"
};
var password = document.getElementById('passwd');
var meter = document.getElementById('password-strength-meter');
var text = document.getElementById('password-strength-text');

// $('#passwd').change(function(){
//   alert('Cambió');
// });
password.addEventListener('input', function() {
  // alert('Input');
    var val = password.value;
    var result = zxcvbn(val);

    // Update the password strength meter
    meter.value = result.score;

    // Update the text indicator
    if (val !== "") {
        text.innerHTML = "Longitud: " + strength[result.score]; 
    } else {
        text.innerHTML = "";
    }
});

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
    meter[value="1"]::-webkit-meter-optimum-value { background: red; }
    meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
    meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
    meter[value="4"]::-webkit-meter-optimum-value { background: green; }

    meter[value="1"]::-moz-meter-bar,
    meter[value="1"]::-moz-meter-bar { background: red; }
    meter[value="2"]::-moz-meter-bar { background: yellow; }
    meter[value="3"]::-moz-meter-bar { background: orange; }
    meter[value="4"]::-moz-meter-bar { background: green; }

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
