@extends('layouts.app')

@section('title', (isset($course)) ? 'Editar curso' : 'Crear curso')

@section('subtitle')
    <ol class="breadcrumb">
      @if(isset($ascription))
        <li><a href="{{route('ascriptions.show', $ascription->id)}}">Adscripción: {{ $ascription->name }}</a></li>
        <li>Crear curso</li>
      @else
        <li>
            <a href="{{ route('courses.index') }}"> Cursos</a>
        </li>
        <li class="active" >
            {{ (isset($course)) ? 'Editar curso' : 'Crear curso' }}
        </li>
      @endif
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{(isset($course)) ? 'Editar curso' : 'Crear curso'}}</h5>
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
                            {!! Form::label('slug', 'Slug del curso:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                             {!! Form::text('slug',null,['class'=>'form-control','placeholder'=>'slug-del-curso', 'required'=>'']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción del curso']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('start_date', 'Fecha de inicio:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::date('start_date',null,['class'=>'form-control']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('end_date', 'Fecha de fin:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::date('end_date',null,['class'=>'form-control']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('support_email', 'Email para resolución de dudas:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                              {!! Form::email('support_email',null,['class'=>'form-control','placeholder'=>'soporte@paecmexico.com', 'required' => '']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('minimum_score', 'Calificación mínima:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::number('minimum_score',null,['class'=>'form-control', 'required'=>'', 'step'=>'0.1']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('has_constancy', '¿Emitirá constancia?',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                              {!! Form::select('has_constancy', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required'=>'']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('category_id', 'Categoría:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              <select name="category_id" id="category_id" class='form-control' required>
                              @if(isset($course))
                                <option value="{{ ($course->category != null) ? $course->category->id : '' }}">
                                  {{ ($course->category != null) ? $course->category->name.' (actual)' : '' }}
                                </option>
                              @endif
                              @if(isset($categories))
                                @forelse($categories as $category)
                                  <option value="{{$category->id}}" >{{ $category->name }}</option>
                                  @empty
                                @endforelse
                              @endif
                              </select>

                            </div>
                          </div>
                          
                          <div class="form-group">
                            {!! Form::label('has_diploma', '¿Ofrecerá diplomado?',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                              {!! Form::select('has_diploma', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control', 'required'=>'']) !!}
                            </div>
                          </div>


                          <div class="form-group">
                            {!! Form::label('certificate_template_id', 'Plantilla para diploma:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              <select name="certificate_template_id" class="form-control" id="certificate_template_id">
                              @if(isset($course))
                                <option value="{{ ($course->certificate_template != null) ? $course->certificate_template->id : 'Seleccionar una plantilla' }}">
                                  {{ ($course->certificate_template != null) ? $course->certificate_template->name.' (actual)' : '' }}
                                </option>
                              @endif
                              @if(isset($templates))
                                @forelse($templates as $template)
                                  <option value="{{$template->id}}" >{{ $template->name }}</option>
                                @empty
                                  <option value="">Aún no existen plantillas</option>
                                @endforelse
                              @else
                                <option value="">Aún no existen plantillas</option>
                              @endif
                              </select>

                            </div>
                          </div>
                          
                          @if(isset($ascription))
                            <input type="hidden" value="{{$ascription->id}}" name="ascription_id">
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
                      <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
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