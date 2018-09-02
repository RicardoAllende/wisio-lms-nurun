@extends('layouts.app')

@section('title','Nuevo recurso')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('courses.show', $module->course->id) }}">Curso: <strong>{{ $module->course->name }}</strong></a>
        </li>
        <li class="active">
            <a href="{{ route('courses.show', $module->id) }}">Módulo: <strong>{{ $module->name }}<strong></a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Agregar recurso a <a href="{{ route('modules.show', $module->id) }}" >{{ $module->name }}</a></h5>
                </div>
                <div class="ibox-content">
                    
                            
                    <div class="row">
                        {!! Form::open(['route' => ['resources.store', $module->id],'class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre del recurso', 'required'=>'']) !!}
                            </div>
                        </div>
                        <input type="hidden" id="attachment_id" value="" name="attachment_id">
                        <input type="hidden" id="module_id" value="{{ $module->id }}" name="module_id">
                        <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="route('modules.show', $module->id )" class="btn btn-default">Cancelar</a>
                            {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave', 'disabled'=> '']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                        <div class="form-group">
                            {!! Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']); !!}
                            {!! Form::open([ 'route' => [ 'attachments.file.upload' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                            <div class="dz-message" style="height:200px;">
                            Arrastre el recurso aquí, formatos soportados: vídeo mp4 y documentos pdf
                            </div>
                            <input type="hidden" value="resources" name="path">
                            <div class="dropzone-previews"></div>
                            <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                            {!! Form::close() !!}
                        </div>
                    <div class="ibox-footer" id='result'></div>
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
        maxFilesize: 400,            
        acceptedFiles: 'video/mp4,application/pdf',
        maxFiles: 1,            
        dictDefaultMessage: 'Arrastra aquí el recurso',            
        init: function() {                
            this.on("success", function(file, response) {                    
                console.log(response);                    
                this.removeFile(file);
                $('#attachment_id').attr('value',response);    
                $('#image-upload').hide();   
                $('#btnSave').prop('disabled', false);
                $('#result').html('El recurso se almacenó correctamente');
                //document.resourceForm.submit();
            });       
            this.on("error", function(error1, error2){
                console.log(error1);
                console.log(error2);
            });
    }        
  };
</script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">
@endsection