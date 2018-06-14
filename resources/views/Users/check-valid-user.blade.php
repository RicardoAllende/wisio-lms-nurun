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
      {!! Form::label('pass', 'Contraseña:' )!!}
      {!! Form::password('password',null,['class'=>'','placeholder'=>'Contraseña', 'required' => '', 'id' => 'password' ]) !!}
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
          <input class="with-gap" name="genero" type="radio" id="hombre"  />
          <label for="hombre">Hombre</label>

        </div>
        <div class="reg col s12 l6">
          <input class="with-gap" name="genero" type="radio" id="mujer"  />
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
            <input class="with-gap" name="consulta" type="radio" id="privado"  />
            <label for="privado">Privado</label><br><br>
            <input class="with-gap" name="consulta" type="radio" id="publica"  />
            <label for="publica">Pública</label><br><br>
            <input class="with-gap" name="consulta" type="radio" id="mixta"  />
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
          {!! Form::label('state', 'Estado:',['class'=>'control-label col-sm-2']); !!}
          <select name="estado">
              <option value="no">Seleccione uno...</option>
              <option value="Aguascalientes">Aguascalientes</option>
              <option value="Baja California">Baja California</option>
              <option value="Baja California Sur">Baja California Sur</option>
              <option value="Campeche">Campeche</option>
              <option value="Chiapas">Chiapas</option>
              <option value="Chihuahua">Chihuahua</option>
              <option value="Cdmx">Ciudad de México</option>
              <option value="Coahuila">Coahuila</option>
              <option value="Colima">Colima</option>
              <option value="Durango">Durango</option>
              <option value="Estado de México">Estado de México</option>
              <option value="Guanajuato">Guanajuato</option>
              <option value="Guerrero">Guerrero</option>
              <option value="Hidalgo">Hidalgo</option>
              <option value="Jalisco">Jalisco</option>
              <option value="Michoacán">Michoacán</option>
              <option value="Morelos">Morelos</option>
              <option value="Nayarit">Nayarit</option>
              <option value="Nuevo León">Nuevo León</option>
              <option value="Oaxaca">Oaxaca</option>
              <option value="Puebla">Puebla</option>
              <option value="Querétaro">Querétaro</option>
              <option value="Quintana Roo">Quintana Roo</option>
              <option value="San Luis Potosí">San Luis Potosí</option>
              <option value="Sinaloa">Sinaloa</option>
              <option value="Sonora">Sonora</option>
              <option value="Tabasco">Tabasco</option>
              <option value="Tamaulipas">Tamaulipas</option>
              <option value="Tlaxcala">Tlaxcala</option>
              <option value="Veracruz">Veracruz</option>
              <option value="Yucatán">Yucatán</option>
              <option value="Zacatecas">Zacatecas</option>
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
        <input type="submit" class="btnAcademia" value="Registrarse"  id="btnSubmit" >
        {!! Form::close() !!}
          <!-- <button id="validate" class="btnAcademia" >Validar cédula</button> -->
      </div>
    </div>



  </div>



@stop

@section('extrajs')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="/js/alertify.min.js"></script>
<script>
$(document).ready(function() {
  $('select').material_select();
});
  $('#validate').click(function (){
    var route = "{{ route('get.response', '') }}";
    if( $('#cedula').val() != '' ){
      route += '/' + $('#cedula').val();
      $.ajax({
        url: route,
        method: 'get',
        success: function(result){
          var json = JSON.parse(result);
          var numFound = json.response.numFound;
          if (numFound == 1 ){
            var registro = json.response.docs[0];
            var nombre = registro.nombre;
            var paterno = registro.paterno;
            var materno = registro.materno;
            if(nombre.toLowerCase() == $('#nombre').val().toLowerCase()  &&
            paterno.toLowerCase() == $('#paterno').val().toLowerCase()   &&
            materno.toLowerCase() == $('#materno').val().toLowerCase()){
              alertify.success('Verificación exitosa');
              $('#cedula').prop('readonly', true);
              $('#nombre').prop('readonly', true);
              $('#paterno').prop('readonly', true);
              $('#materno').prop('readonly', true);
              $('#btnSubmit').show();
              $('#adicionales').show();
              $('#validate').hide();
            }else{
              alertify.error('Los datos no coinciden, verifíquelos');
            }
          }else{
            alertify.error('Cédula profesional no encontrada');
          }
        }
      });
    }
  });
</script>
@stop
@section('extracss')
<link rel="stylesheet" href="/css/alertify.core.css">
<link rel="stylesheet" href="/css/alertify.bootstrap.css">
<link rel="stylesheet" href="/css/alertify.default.css">
@endsection
