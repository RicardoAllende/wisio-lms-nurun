@extends('layouts.app')

@section('title','Evaluation')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar evaluación</h5>
                        
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
                              {!! Form::label('minimum_score', 'Calificación aprobatoria mínima:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::number('minimum_score',null,['class'=>'form-control','placeholder'=>'Calificación aprobatoria mínima (usar enteros)', 'required' => '', "min"=>1, 'max'=>10]) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('maximum_attemps', 'Cantidad de intentos máximos:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                               {!! Form::number('maximum_attemps',null,['class'=>'form-control','min' => 0, 'placeholder'=>'Cantidad de intentos máximos (ingrese 0 para no limitar los intentos)', 'required' => '']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('start_date', 'Fecha de inicio:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::date('start_date',null,['class'=>'form-control', 'required'=>'']) !!}
                              </div>
                            </div>
                            <div class="form-group">
                              {!! Form::label('end_date', 'Fecha de fin:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                                {!! Form::date('end_date',null,['class'=>'form-control', 'required'=>'']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              {!! Form::label('type_label', 'Tipo:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10"> 
                              {!! Form::select('type',[''=>'Seleccione una opcion','f'=>'Examen','d'=>'Diagnóstico'],null,['class'=>'form-control', 'required'=>'']) !!}
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
                        <input type="hidden" value="main_img" name="type">
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