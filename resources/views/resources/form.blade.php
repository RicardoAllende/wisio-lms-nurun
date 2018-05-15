@extends('layouts.app')

@section('title','Nuevo recurso')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para subir recurso</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">


                            <div class="form-group">
                                {!! Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']); !!}
                                {!! Form::open([ 'route' => [ 'attachments.file.upload' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                                <div class="dz-message" style="height:200px;">
                                Arrastre el recurso aquí
                                </div>
                                <input type="hidden" value="{{ config('constants.resources.video') }}" name="type">
                                <input type="hidden" value="resources" name="path">
                                <div class="dropzone-previews"></div>
                                <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                                {!! Form::close() !!}
                            </div>

                        </div>
                    <div class="ibox-footer" id='result'></div>
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
            // acceptedFiles: 'video/*',            
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