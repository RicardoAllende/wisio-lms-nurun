@extends('layouts.app')

@section('title', (isset($user)) ? 'Editar usuario' : 'Crear usuario')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('users.index') }}">Usuarios</a>
        </li>
        <li class="active" >
            {{ (isset($user)) ? 'Editar usuario' : 'Crear usuario' }}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Formulario para {{(isset($user)) ? 'editar usuario' : 'crear usuario'}}</h5><br>
        </div>
        <h4>Nota, para esta verificación ingrese su nombre tal y como aparece en su cédula profesional (podrán ser editados posteriormente)</h4>
        <h5>0756579  ERNESTO MORALES </h5>
        <!--<h5>| Llevet              | Guzman Juarez       | NULL       | 3792167   |</h5>
        <h5>| Jorge Alberto       | Romero rea          | NULL       | 9737184   |</h5>
        <h5>| Nilce Elizabeth     | Maldonado Osorio    | NULL       | 9700477   |</h5>-->
        <div class="ibox-content">
          <div class="row ">
          {!! Form::open(['route' => 'public.register', 'class'=>'form-horizontal','method' => 'post']) !!}
            <div class="form-group">
              {!! Form::label('cedula', 'Cédula:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::number('cedula',null,['class'=>'form-control','placeholder'=>'Cédula profesional; si su cédula profesional tiene menos de 7 dígitos, agrege 0 hasta completar los 7 números', 'required' => '', 'id' => 'cedula' ]) !!}
              </div>
            </div>

            <input type="hidden" name="public_register" value="1">

            <div class="form-group">
              {!! Form::label('firstname', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::text('firstname',null,['class'=>'form-control','placeholder'=>'Nombre', 'id' => 'nombre']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('paterno', 'Apellido paterno:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10"> 
                {!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Apellidos', 'id'=> 'paterno' ]) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('materno', 'Apellido materno:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::text('materno',null,['class'=>'form-control','placeholder'=>'Apellidos', 'id'=> 'materno' ]) !!}
              </div>
            </div>
            <br>
            <div id="adicionales" style="display:none" >
                <div class="form-group">
                  {!! Form::label('email', 'Correo electrónico:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10">
                    {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'id'=> 'email', 'required' => '' ]) !!}
                  </div>
                </div>

                <div class="form-group">
                    {!! Form::label('gender', 'Género:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10"><!-- M->Male; F->Female -->
                    {!! Form::select('gender', ['' => 'Seleccionar género', 'F' => 'Femenino', 'M' => 'Masculino'], null, ['class' => 'form-control', 'required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('specialty_id', 'Especialidad:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10">
                    <select name="specialty_id" id="specialty_id" required class="form-control">
                      @inject('specialtiesController','App\Http\Controllers\AdminControllers\SpecialtiesController')
                      @foreach($specialtiesController->getAllSpecialties() as $specialty)
                        <option value="{{$specialty->id}}"> {{$specialty->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                    {!! Form::label('consultation_type', 'Tipo de consulta:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10"><!-- M->Male; F->Female -->
                    {!! Form::select('consultation_type', ['' => 'Tipo de consulta', 'Pública' => 'Pública', 'Privada' => 'Privada', 'Ambas' => 'Ambas'], null, ['class' => 'form-control', 'required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10">
                    {!! Form::number('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10"> 
                    {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña', 'required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  <center>
                    <div class="g-recaptcha" data-sitekey="6Lc701oUAAAAAGUQmLqCRKjBHwWOwBRIjzAtpmr5"></div>
                  </center>
                </div>
              
            </div><!-- Fin adicionales -->
            <br>
            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-round" value="Registrarse" style='display:none;' id="btnSubmit" >
              
              </div>
            </div>
            
              {!! Form::close() !!}
                <button id="validate" class="btn btn-info btn-round" >Validar cédula</button>
            
          </div>
        </div>
        <div class="ibox-footer">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="/js/alertify.min.js"></script>
  <script>
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
@endsection

@section('styles')
<link rel="stylesheet" href="/css/alertify.core.css">
<link rel="stylesheet" href="/css/alertify.bootstrap.css">
<link rel="stylesheet" href="/css/alertify.default.css">
@endsection