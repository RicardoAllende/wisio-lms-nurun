@extends('layouts.app')

@section('title','Crear/Actualizar curso')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar curso</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                      @if(!isset($course))
                        {!! Form::open(['route' => 'courses.store','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                      @else
                        {!! Form::model($course,['route' => ['courses.update',$course->id],'class'=>'form-horizontal','method' => 'put']) !!}
                      @endif
                          <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                             {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required'=>'']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('descripcion', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción del curso', 'required'=>'']) !!}
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
                            {!! Form::label('has_constancy', '¿Emitirá constancia?',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                              {!! Form::checkbox('has_constancy', '1', true)  !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('category_id', 'Categoría:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              <select name="category_id" id="category_id" required>
                              @if(isset($categories))
                                @forelse($categories as $category)
                                  <option value="{{$category->id}}" >{{ $category->name }}</option>
                                @empty
                                  <option value="_">Aún no existen categorías</option>
                                @endforelse
                              @else
                                <option value="_">Aún no existen categorías</option>
                              @endif
                              </select>

                            </div>
                          </div>
                          
                          @if(isset($ascription_id))
                            <input type="hidden" value="{{$ascription_id}}" name="ascription_id">
                          @endif


                          
                          <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/courses" class="btn btn-default">Cancelar</a>
                              {!! Form::hidden('attachment',null,['class'=>'form-control','id'=>'attachment']) !!}
                              @if(isset($course))
                                @if($course->attachments->where('type', 'main_img')->count() > 0)
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
                          @if(isset($course))
                            @if($course->hasMainImg())
                              {{ 'Arrastre aquí una imagen para actualizarla' }}
                            @else
                              {{ 'Arrastre aquí la imagen del curso (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen del curso (requerida)' }}
                          @endif
                      </div>
                      <input type="hidden" value="main_img" name="type">
                      <input type="hidden" value="courses" name="path">
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