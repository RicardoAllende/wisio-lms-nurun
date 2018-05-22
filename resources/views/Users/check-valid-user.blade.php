@section('title')
Login
@stop
@extends('users_pages.master')
@section('body')
  <div class="row" style="padding: 3%;">
    <h5>Nota, para esta verificación ingrese su nombre tal y como aparece en su cédula profesional (podrán ser editados posteriormente)</h5>
    <h6>0756579  ERNESTO MORALES </h6>
    {!! Form::open(['route' => 'public.register', 'class'=>'form-horizontal','method' => 'post', 'autocomplete' => 'off']) !!} 
      <div class="form-group">
              {!! Form::label('cedula', 'Cédula:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::number('cedula',null,['placeholder'=>'Cédula profesional; si su cédula profesional tiene menos de 7 dígitos, agrege 0 hasta completar los 7 números', 'required' => '', 'id' => 'cedula' ]) !!}
              </div>
            </div>

            <input type="hidden" name="public_register" value="1">

            <div class="form-group">
              {!! Form::label('firstname', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::text('firstname',null,['placeholder'=>'Nombre', 'id' => 'nombre']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('paterno', 'Apellido paterno:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10"> 
                {!! Form::text('paterno',null,['placeholder'=>'Apellidos', 'id'=> 'paterno' ]) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('materno', 'Apellido materno:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::text('materno',null,['placeholder'=>'Apellidos', 'id'=> 'materno' ]) !!}
              </div>
            </div>
            <br>
            <div id="adicionales" style="display:none" >
                <div class="form-group">
                  {!! Form::label('email', 'Correo electrónico:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10">
                    {!! Form::email('email',null,['placeholder'=>'Correo electrónico', 'id'=> 'email' ]) !!}
                  </div>
                </div>

                <div class="form-group">
                    {!! Form::label('gender', 'Género:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10"><!-- M->Male; F->Female -->
                    {!! Form::select('gender', ['' => 'Seleccionar género', 'F' => 'Femenino', 'M' => 'Masculino'], null, ['required' => '']) !!}
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
                    {!! Form::select('consultation_type', ['' => 'Tipo de consulta', 'Pública' => 'Pública', 'Privada' => 'Privada', 'Ambas' => 'Ambas'], null, ['required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10">
                    {!! Form::number('mobile_phone',null,['placeholder'=>'Teléfono celular', 'required' => '']) !!}
                  </div>
                </div>

                <div class="form-group">
                  {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                  <div class="col-sm-10"> 
                    {!! Form::password('password',['placeholder'=>'Contraseña', 'required' => '']) !!}
                  </div>
                </div>
              
            </div><!-- Fin adicionales -->
            <br>
            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-round" value="Registrarse" style='display:none;' id="btnSubmit" >
              
              </div>
            </div>
            
              {!! Form::close() !!}
                <button id="validate" class="btn btn-info btn-round" >Validar información</button>
            
  </div>
@endsection

@section('extrajs')
  <script src="/js/alertify.min.js"></script>
  <script>
  alertify.success('Notificación');
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
                // $('#btnSubmit').prop('disabled', false);
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