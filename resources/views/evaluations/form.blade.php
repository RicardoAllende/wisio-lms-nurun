@extends('layouts.app')

@section('title', (isset($evaluation))? 'Editar evaluación' : 'Crear evaluación')

@if(isset($evaluation))
  @section('subtitle')
      <ol class="breadcrumb">
          <li>
            <a href="{{ route('courses.show', $evaluation->module->course->id) }}"> Curso: {{ $evaluation->module->course->name }}</a>
          </li>
          <li>
            <a href="{{ route('modules.show', $evaluation->module->id) }}"> Módulo: {{$evaluation->module->name}} </a>
          </li>
          <li class="active" >
              {{ (isset($evaluation))? 'Editar evaluación' : 'Crear evaluación' }}
          </li>
      </ol>
  @endsection
@else
  @section('subtitle')
      <ol class="breadcrumb">
          <li>
            <a href="{{ route('evaluations.index') }}"> Evaluaciones</a>
          </li>
          <li class="active" >
              Editar evaluación
          </li>
      </ol>
  @endsection
@endif

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($evaluation))? 'Editar evaluación' : 'Crear evaluación'}}</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(isset($evaluation))
                          {!! Form::model($evaluation,['route' => ['evaluations.update', $evaluation->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @else
                          {!! Form::open(['route' => 'evaluations.store','class'=>'form-horizontal','method' => 'post']) !!}
                        @endif
                            @if(isset($module))
                            <div class="form-group">
                                {!! Form::label('module_id', 'Agregando al módulo:',['class'=>'control-label col-sm-2']); !!}
                                <div class="col-sm-10">
                                  <input type="text" value="{{$module->name}}" class="form-control" disabled>
                                </div>
                              </div>
                            <input type="hidden" name="module_id" value="{{$module->id}}">
                            @else
                              @if(isset($modules))
                              <div class="form-group">
                                {!! Form::label('module_id', 'Módulo correspondiente:',['class'=>'control-label col-sm-2']); !!}
                                <div class="col-sm-10">
                                  
                                  <select name="module_id" id="module_id" class="form-control">
                                    
                                      @foreach($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>
                              @endif
                            @endif

                            <div class="form-group">
                              {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('maximum_attempts', 'Cantidad de intentos máximos:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::number('maximum_attempts',null,['class'=>'form-control','min' => 0, 'placeholder'=>'Cantidad de intentos máximos', 'required' => '']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              {!! Form::label('type_label', 'Tipo:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                              {!! Form::select('type',[''=>'Seleccione una opcion', config('constants.evaluations.diagnostic') =>'Examen', config('constants.evaluations.final') =>'Diagnóstico'],null,['class'=>'form-control', 'required'=>'']) !!}
                              </div>
                            </div>
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                              <a href="{{ route('evaluations.index') }}" class="btn btn-default">Cancelar</a>
                              {!! Form::hidden('attachment',null,['class'=>'form-control','placeholder'=>'','id'=>'attachment']) !!}
                              @if(isset($evaluation))
                                @if($evaluation->hasMainImg())
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
                              {{ 'Arrastre aquí la imagen de la evaluación (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen de la evaluación (requerida)' }}
                          @endif
                      </div>
                      <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
                        <input type="hidden" value="evaluations" name="path">
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
            maxFilesize: 10,            
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