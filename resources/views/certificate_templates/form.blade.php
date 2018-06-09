@extends('layouts.app')

@section('title','Nueva plantilla')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('templates.index') }}">Plantillas para diploma</strong></a>
        </li>
        <li class="active">
            <a>Crear plantilla</a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <div class="row">
                        @if(isset($template))
                        {!! Form::model($template,['route' => ['templates.update', $template->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @else
                        {!! Form::open(['route' => ['templates.store'], 'class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('name', 'Nombre:',['class'=>'control-label col-sm-2']); !!}
                            <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre de la plantilla', 'required'=>'']) !!}
                            </div>
                        </div>
                        <input type="hidden" id="attachment_id" value="" name="attachment_id">
                        <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave', 'disabled'=> '']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}

                        <div class="form-group">
                            {!! Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']); !!}
                            {!! Form::open([ 'route' => [ 'attachments.file.upload' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                            <div class="dz-message" style="height:200px;">
                                Arrastre la plantilla aquí, es recomendable que tenga una resolución aproximada de 1024 x 750px
                            </div>
                            <input type="hidden" value="certificates" name="path">
                            <div class="dropzone-previews"></div>
                            <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                            {!! Form::close() !!}
                        </div>
                    </div>
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
        maxFilesize: 200,            
        acceptedFiles: 'image/*',
        maxFiles: 1,
        dictDefaultMessage: 'Arrastra aquí el recurso',
        init: function() {       
            this.on("success", function(file, response) {                    
                console.log(response);                    
                this.removeFile(file);
                $('#attachment_id').attr('value',response);    
                $('#image-upload').hide();   
                $('#btnSave').prop('disabled', false);
                $('#result').html('Archivo subido correctamente, dé clic en guardar para crear la plantilla');
                //document.resourceForm.submit();
            });            
    }        
  };
</script>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">
@endsection