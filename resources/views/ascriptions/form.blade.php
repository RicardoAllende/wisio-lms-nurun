@extends('layouts.app')

@section('title', (isset($ascription)) ? 'Editar adscripción' : 'Crear adscripción')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('ascriptions.index') }}"> Adscripciones</a>
        </li>
        <li class="active" >
            {{(isset($ascription)) ? 'Editar adscripción' : 'Crear adscripción'}}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      @if(isset($ascription))
                        <h5>Editar adscripción</h5>
                      @else
                        <h5>Crear adscripción</h5>
                      @endif
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($ascription))
                          {!! Form::open(['route' => 'ascriptions.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($ascription,['route' => ['ascriptions.update', $ascription->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                                {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre de la adscripción o farmacia', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('slug', 'Slug:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                {!! Form::text('slug', null, ['class'=>'form-control','placeholder'=>'Slug, ejemplo: del-ahorro', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('is_pharmacy', 'Tipo de adscripción:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                {!! Form::select('is_pharmacy', ['1' => 'Farmacia', '0' => 'Principal'], null, ['class' => 'form-control']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción', 'required' => '']) !!}
                              </div>
                            </div>
                            {!! Form::hidden('attachment',null,['class'=>'form-control','id'=>'attachment']) !!}
                            <div class="form-group"> 
                              <div class="col-sm-offset-2 col-sm-10">
                              <a href="{{route('ascriptions.index')}}" class="btn btn-default">Cancelar</a>
                              @if(isset($ascription))
                                @if($ascription->hasMainImg())
                                  {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave']) !!}
                                @else
                                  {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'disabled' => '', 'id' => 'btnSave']) !!}
                                @endif
                              @else
                                {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'disabled' => '', 'id' => 'btnSave']) !!}
                              @endif
                              
                            </div>
                          </div>
                        {!! Form::close() !!}
                    </div>
                    
                      <div class="form-group">
                        {!! Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']); !!}
                        {!! Form::open([ 'route' => [ 'attachments.file.upload' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                        <div class="dz-message" style="height:200px;">
                          @if(isset($ascription))
                            @if($ascription->hasMainImg())
                              {{ 'Arrastre aquí una imagen para actualizarla' }}
                            @else
                              {{ 'Arrastre aquí la imagen de la adscripción/farmacia (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen de la adscripción/farmacia (requerida)' }}
                          @endif
                        </div>
                        <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
                        <input type="hidden" value="ascriptions" name="path">
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
                $('#attachment').attr('value',response);    
                $('#image-upload').hide();   
                $('#btnSave').prop('disabled', false);

              });            
            }        
  };
</script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">
@endsection