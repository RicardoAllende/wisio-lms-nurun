@extends('layouts.app')

@section('title', (isset($diploma)) ? 'Editar diploma' : 'Crear diploma')

@section('subtitle')
    <ol class="breadcrumb">
      @if(isset($ascription))
        <li><a href="{{route('ascriptions.show', $ascription->id)}}">Adscripción: {{ $ascription->name }}</a></li>
        <li>Crear diploma</li>
      @else
        <li>
            <a href="{{ route('diplomas.index') }}"> Diplomas</a>
        </li>
        <li class="active" >
            {{ (isset($diploma)) ? 'Editar diploma' : 'Crear diploma' }}
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
                        <h5>{{(isset($diploma)) ? 'Editar diploma' : 'Crear diploma'}}</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                      @if(!isset($diploma))
                        {!! Form::open(['route' => 'diplomas.store','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                      @else
                        {!! Form::model($diploma,['route' => ['diplomas.update',$diploma->id],'class'=>'form-horizontal','method' => 'put']) !!}
                      @endif
                          <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                             {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre', 'required'=>'']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('slug', 'Slug del diploma:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                             {!! Form::text('slug',null,['class'=>'form-control','placeholder'=>'slug-del-diploma', 'required'=>'']) !!}
                            </div>
                          </div>
                          <div class="form-group">
                            {!! Form::label('description', 'Descripción:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::textArea('description',null,['class'=>'form-control', 'id' => 'description', 'required' => '']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('minimum_score', 'Calificación mínima:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::number('minimum_score',null,['class'=>'form-control', 'required'=>'', 'placeholder' => 'Calificación mínima aprobatoria del diplomado', 'step'=>'0.1']) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('minimum_previous_score', 'Calificación mínima de los cursos anteriores:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              {!! Form::number('minimum_previous_score',null,['class'=>'form-control', 'required'=>'', 'step'=>'0.1','placeholder' => "Promedio mínimo de los cursos anteriores" ]) !!}
                            </div>
                          </div>

                          <div class="form-group">
                            {!! Form::label('ascription_id', 'Adscripción:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10"> 
                              <select name="ascription_id" id="ascription_id" class='form-control' required>
                              @if(isset($diploma))
                                <option value="{{ ($diploma->ascription != null) ? $diploma->ascription->id : '' }}">
                                  {{ ($diploma->ascription != null) ? $diploma->ascription->name.' (actual)' : '' }}
                                </option>
                              @endif
                              @if(isset($ascriptions))
                                @forelse($ascriptions as $ascription)
                                  <option value="{{$ascription->id}}" >{{ $ascription->name }}</option>
                                  @empty
                                @endforelse
                              @endif
                              </select>

                            </div>
                          </div>


                          
                          <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="{{ route('diplomas.index') }}" class="btn btn-default">Cancelar</a>
                              {!! Form::hidden('attachment',null,['class'=>'form-control','id'=>'attachment']) !!}
                              @if(isset($diploma))
                                @if($diploma->attachments->where('type', 'main_img')->count() > 0)
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
                          @if(isset($diploma))
                            @if($diploma->hasMainImg())
                              {{ 'Arrastre aquí una imagen para actualizarla' }}
                            @else
                              {{ 'Arrastre aquí la imagen del diploma (requerida)' }}
                            @endif
                          @else
                            {{ 'Arrastre aquí la imagen del diploma (requerida)' }}
                          @endif
                      </div>
                      <input type="hidden" value="{{ config('constants.attachments.main_img') }}" name="type">
                      <input type="hidden" value="diplomas" name="path">
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
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  CKEDITOR.replace('description');
  Dropzone.options.imageUpload  = {            
            paramName: "file", 
            // The name that will be used to transfer the file            
            maxFilesize: 10,            
            acceptedFiles: 'image/*',            
            maxFiles: 1,            
            dictDefaultMessage: 'Arrastra aquí la imagen del diploma',            
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