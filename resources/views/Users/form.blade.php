@extends('layouts.app')

@section('title','Usuarios')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar usuario</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                        @if(!isset($user))
                          {!! Form::open(['url' => '/users','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($user,['url' => '/users/'.$user->id,'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('nombre', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('firstname',null,['class'=>'form-control','placeholder'=>'Nombre']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('apellidos', 'Apellidos:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::text('lastname',null,['class'=>'form-control','placeholder'=>'Apellidos']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('email', 'Email:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('birthday', 'Fecha de nacimiento:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::date('birth_day',null,['class'=>'form-control','placeholder'=>'']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('gender', 'Sexo',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                               {!! Form::select('gender',[''=>'Seleccione una opcion','M'=>'Masculino','F'=>'Femenino'],null,['class'=>'form-control']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('typeuser', 'Tipo de Usuario:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                               {!! Form::select('type',[''=>'Seleccione una opcion','0'=>'Administrador','1'=>'Usuario'],null,['class'=>'form-control']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('source_label', 'Source:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::text('source',null,['class'=>'form-control','placeholder'=>'Source']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('token_label', 'Token:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::text('source_token',null,['class'=>'form-control','placeholder'=>'Source_token']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('lastaccess_label', 'Ultimo acceso:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::date('last_access',null,['class'=>'form-control','placeholder'=>'']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('enabled_label', 'Habilitado:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                               {!! Form::select('enable',[''=>'Seleccione una opcion','0'=>'Activo','1'=>'Desactivado'],null,['class'=>'form-control']) !!}
                              </div>
                            </div>
                            <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/users" class="btn btn-default">Cancelar</a>
                            {!! Form::hidden('photo',null,['class'=>'form-control','placeholder'=>'','id'=>'photo']) !!}

                             {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
                            </div>
                          </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('photo_label', 'Imagen:',['class'=>'control-label col-sm-2']); !!}
                      {!! Form::open([ 'url' => [ '/users/uploadImage' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                      <div class="dz-message" style="height:200px;">
                          Arrastre su imagen aquí...
                      </div>
                      <div class="dropzone-previews"></div>
                      <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                      {!! Form::close() !!}
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
<script type="text/javascript" src="/js/plugins/dropzone/dropzone.js"></script>
<script type="text/javascript">

      Dropzone.options.imageUpload  = {            
                paramName: "file", 
                // The name that will be used to transfer the file            
                maxFilesize: 2,            
                acceptedFiles: 'image/*',            
                maxFiles: 1,            
                dictDefaultMessage: 'Arrastra aquí una fotopara el perfil del usuario',            
                //previewTemplate: '  ',            
                init: function() {                
                  this.on("success", function(file, response) {                    
                    console.log(response);                    
                    this.removeFile(file);
                    $('#photo').attr('value',response);    
                    $('#image-upload').hide();   
                    $('#guardar').removeClass('disabled');

                  });            
                }        
              };
    </script>

@endsection

@section('styles')

<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">

@endsection
     