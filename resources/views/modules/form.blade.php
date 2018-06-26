@extends('layouts.app')

@section('title',(isset($module)) ? 'Editar módulo' : 'Crear módulo')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('modules.index') }}"> Módulos</a>
        </li>
        <li class="active" >
            {{(isset($module)) ? 'Editar módulo' : 'Crear módulo'}}
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($module)) ? 'Editar módulo' : 'Crear módulo' }}</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                      @if(!isset($module))
                        {!! Form::open(['route' => 'modules.store','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                      @else
                        {!! Form::model($module,['route' => ['modules.update', $module->id],'class'=>'form-horizontal','method' => 'put']) !!}
                      @endif
                          <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                             {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required'=>'']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción', 'required'=>'']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('sort', 'Orden:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::number('sort',null,['class'=>'form-control','placeholder'=>'Orden']) !!}
                            </div>
                          </div>
                          
                          <div class="form-group">
                            {!! Form::label('course', 'Curso:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                            @if(isset($course))
                              <input type="hidden" name="course_id" value="{{$course->id}}">
                              <input type="text" class="form-control" disabled value="{{ $course->name }}">
                            @else
                              <select name="course_id" id="course_id" class="form-control">
                                @if(isset($module))
                                  <option value="{{ $module->course->id }}">{{ $module->course->name }} (actual)</option>
                                @else
                                  <option value="">Seleccionar </option>
                                @endif
                                @foreach($courses as $course)
                                  <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                                </select>
                            @endif
                            </div>
                          </div>
                          

                          @if(isset($expert_id))
                            <input type="hidden" name="expert_id" value="{{$expert_id}}">
                          @endif
                          
                          <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/courses" class="btn btn-default">Cancelar</a>
                            {!! Form::hidden('attachment',null,['class'=>'form-control','placeholder'=>'','id'=>'attachment']) !!}
                            @if(isset($module))
                              @if($module->hasMainImg() > 0)
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
                          @if(isset($evaluation))
                            @if($evaluation->hasMainImg())
                              {{ 'Arrastre aquí una imagen para actualizarla' }}
                            @else
                              {{ 'Arrastre aquí la imagen del módulo (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen del módulo (requerida)' }}
                          @endif
                      </div>
                      <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
                        <input type="hidden" value="modules" name="path">
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
                dictDefaultMessage: 'Arrastra aquí la imagen del curso',            
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
