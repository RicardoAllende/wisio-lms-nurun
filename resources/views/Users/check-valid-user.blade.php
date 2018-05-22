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
        <h4>Nota, para esta verificación ingrese su nombre tal y como aparece en su cédula profesional</h4>
        <h5>0756579  ERNESTO MORALES </h5>
        <div class="ibox-content">
          <div class="row ">
          {!! Form::open(['route' => 'users.store', 'class'=>'form-horizontal','method' => 'post']) !!}
            <div class="form-group">
              {!! Form::label('cedula', 'Cédula:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::number('cedula',null,['class'=>'form-control','placeholder'=>'Cédula profesional', 'required' => '', 'id' => 'cedula' ]) !!}
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
                    {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'id'=> 'email' ]) !!}
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
              
            </div><!-- Fin adicionales -->
            <br>
            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <a href="{{route('users.index')}}" class="btn btn-default">Cancelar</a>
                <input type="submit" class="btn btn-success btn-round" value="Registrarse" disabled='' id="btnSubmit" >
              
              </div>
            </div>
            
              {!! Form::close() !!}
                <button id="validate" class="btn btn-info btn-round" >Validar información</button>
            
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
                alert('Datos coinciden');
                $('#cedula').prop('disabled', true);
                $('#nombre').prop('disabled', true);
                $('#paterno').prop('disabled', true);
                $('#materno').prop('disabled', true);
                $('#btnSubmit').prop('disabled', false);
                $('#adicionales').show();
              }else{
                alert('Los datos no coinciden');
              }
            }
          }
        });
      }
    });
  </script>
@endsection
