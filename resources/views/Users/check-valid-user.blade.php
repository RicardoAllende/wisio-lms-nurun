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
          <h5>Formulario para {{(isset($user)) ? 'editar usuario' : 'crear usuario'}}</h5>
        </div>
        <div class="ibox-content">
          <div class="row ">

            <div class="form-group">
              {!! Form::label('cedula', 'Cédula:',['class'=>'control-label col-sm-2']); !!}
              <div class="col-sm-10">
                {!! Form::email('cedula',null,['class'=>'form-control','placeholder'=>'Cédula profesional', 'required' => '', 'id' => 'cedula' ]) !!}
              </div>
            </div>

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
            <input type="submit" class="btn btn-success btn-round" value="Registrarse" disabled id="btnSubmit" >
            {!! Form::close() !!}
            <button id="validate" class="btn btn-info btn-round" >Validar opción</button>
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
            if(result != '' ){
              var json = JSON.parse(result) ;
              // console.log(json.responseHeader);
              var numFound = json.response.numFound;
              if (numFound == 1 ){
                var isValid = true;
                var registro = json.response.docs[0];
                var nombre = registro.nombre;
                var paterno = registro.paterno;
                var materno = registro.materno;
                if(nombre.toLowerCase() == $('#nombre').val().toLowerCase() ){
                  isvalid = false;
                }
                if(paterno.toLowerCase() == $('#paterno').val().toLowerCase() ){
                  isvalid = false;
                }
                if(materno.toLowerCase() == $('#materno').val().toLowerCase() ){
                  isvalid = false;
                }
                if(isValid){
                  alert('Datos coinciden')
                  $('btnSubmit').attr('disabled', false);
                }else{
                  alert('Los datos no coinciden');
                }
              }
            }
          }
        });
      }
    });
    /**
    http://search.sep.gob.mx/solr/cedulasCore/select?&q=1072684&wt=json  Pineda
    http://search.sep.gob.mx/solr/cedulasCore/select?&q=7402829&wt=json    Jaques
    http://search.sep.gob.mx/solr/cedulasCore/select?&q=0610000&wt=json    Cuellar Se agrega un 0, para tener 7 dígitos
    
    http://search.sep.gob.mx/solr/cedulasCore/select?&wt=json&q=0756579
    */
  </script>
@endsection
