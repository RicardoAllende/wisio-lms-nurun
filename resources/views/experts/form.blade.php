@extends('layouts.app')

@section('title', (isset($expert)) ? 'Editar experto' : 'Crear Experto')

@if(isset($expert))
  @section('cta')
    <a href="{{route('list.specialties.for.expert', $expert->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i>Administrar especialidades</a>
    <a href="{{route('list.modules.for.expert', $expert->id)}}" class="btn btn-primary "><i class='fa fa-edit'></i>Administrar módulos</a>
  @endsection
@endif

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('experts.index') }}">Expertos</a>
        </li>
        <li class="active" >
            {{(isset($expert)) ? 'Editar experto' : 'Crear experto'}}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($expert)) ? 'Editar experto' : 'Crear Experto' }}</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($expert))
                          {!! Form::open(['route' => 'experts.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($expert,['route' => ['experts.update', $expert->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif
                            <div class="form-group">
                              {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Dr. Enrique Graue', 'required' => '']) !!}
                              </div>
                            </div>
                            
                            <div class="form-group">
                              {!! Form::label('summary', 'Resumen:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                <textarea name="summary" id="summary" cols="30" rows="10" class="form-control" placeholder="Resumen de CV del experto">@if(isset($expert)){{ $expert->summary }}@endif</textarea>
                              </div>
                            </div>
                            
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="{{route('experts.index')}}" class="btn btn-default">Cancelar</a>
                             {!! Form::hidden('attachment',null,['class'=>'form-control','placeholder'=>'','id'=>'featured_image']) !!}
                              @if(isset($expert))
                                @if($expert->hasMainImg())
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
                      {!! Form::open([ 'route' => 'attachments.file.upload', 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                      <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
                        <input type="hidden" value="experts" name="path">
                      <div class="dz-message" style="height:200px;">
                          @if(isset($expert))
                            @if($expert->hasMainImg())
                              {{ 'Arrastre aquí una imagen para actualizarla' }}
                            @else
                              {{ 'Arrastre aquí la imagen del experto (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen del experto (requerida)' }}
                          @endif
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
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/js/plugins/dropzone/dropzone.js"></script>
<script type="text/javascript">
      CKEDITOR.replace( 'summary' );
      Dropzone.options.imageUpload  = {            
                paramName: "file", 
                // The name that will be used to transfer the file            
                maxFilesize: 10,            
                acceptedFiles: 'image/*',            
                maxFiles: 1,            
                dictDefaultMessage: 'Arrastra aquí una fotopara el perfil del usuario',            
                //previewTemplate: '  ',            
                init: function() {                
                  this.on("success", function(file, response) {                    
                    console.log(response);                    
                    this.removeFile(file);
                    $('#featured_image').attr('value',response);    
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
     