@section('title')
Registro
@stop
@extends('users_pages.master')
@section('body')

<div class="row pad-left3">
  <h2 class="recientes">Registro de usuarios</h2>
  <div class="col s6 l9">
     <hr class="line"/>
  </div>
  <div class="col s6 l3">
     <h2 class="recientes">Ingrese sus Datos</h2>
  </div>

</div>

<div class="row">
  {!! Form::open(['route' => 'public.register', 'class'=>'form-horizontal col s12','method' => 'post']) !!}
  <div class="row">
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('cedula', 'Cédula:' )!!}
      {!! Form::number('cedula',null,['class'=>'','placeholder'=>'Cédula profesional; si su cédula profesional tiene menos de 7 dígitos, agrege 0 hasta completar los 7 números', 'required' => '', 'id' => 'cedula' ]) !!}
    </div>
    <input type="hidden" name="public_register" value="1">
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('firstname', 'Nombre:',['for'=>'firstname']); !!}
      {!! Form::text('firstname',null,['class'=>'validate','placeholder'=>'Nombre', 'id' => 'nombre']) !!}

    </div>
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('paterno', 'Apellido paterno:',['for'=>'paterno']); !!}
      {!! Form::text('paterno',null,['class'=>'validate','placeholder'=>'Apellidos', 'id'=> 'paterno' ]) !!}

    </div>
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('materno', 'Apellido materno:',['for'=>'paterno']); !!}
      {!! Form::text('materno',null,['class'=>'validate','placeholder'=>'Apellidos', 'id'=> 'materno' ]) !!}

    </div>
    <br>
    <div id="adicionales" style="display:none">
      <div class="reg col s12 l6 offset-l3">
        {!! Form::label('email', 'Correo electrónico:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'id'=> 'email', 'required' => '' ]) !!}

      </div>
      <div class="reg col s12 l6 offset-l3">
        {!! Form::label('gender', 'Género:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::select('gender', ['' => 'Seleccionar género', 'F' => 'Femenino', 'M' => 'Masculino'], null, ['class' => '', 'required' => '']) !!}

      </div>
      <div class="reg col s12 l6 offset-l3">
        {!! Form::label('specialty_id', 'Especialidad:',['class'=>'']); !!}
        <select name="specialty_id" id="specialty_id" required class="">
          @inject('specialtiesController','App\Http\Controllers\AdminControllers\SpecialtiesController')
          @foreach($specialtiesController->getAllSpecialties() as $specialty)
            <option value="{{$specialty->id}}"> {{$specialty->name}} </option>
          @endforeach
        </select>

      </div>
      <div class="reg col s12 l6 offset-l3">
          {!! Form::label('consultation_type', 'Tipo de consulta:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::select('consultation_type', ['' => 'Tipo de consulta', 'Pública' => 'Pública', 'Privada' => 'Privada', 'Ambas' => 'Ambas'], null, ['class' => '', 'required' => '']) !!}

      </div>
      <div class="reg col s12 l6 offset-l3">
        {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::number('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '']) !!}

      </div>
      <div class="reg col s12 l6 offset-l3">
        {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña', 'required' => '']) !!}

      </div>
      <div class="col s12 l6 offset-l3">
        <center>
          <div class="g-recaptcha" data-sitekey="6Lc701oUAAAAAGUQmLqCRKjBHwWOwBRIjzAtpmr5"></div>
        </center>

      </div>
    </div>
    <br>
    <div class="row">
      <div class="col s12 l6 offset-l3">
        <input type="submit" class="btnAcademia" value="Registrarse" style='display:none;' id="btnSubmit" >
        {!! Form::close() !!}
          <button id="validate" class="btnAcademia" >Validar cédula</button>
      </div>
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
