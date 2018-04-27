@extends('layouts.app')

@section('title','Recursos')

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
                            {!! Form::open([ 'route' => [ 'upload.resource' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                            <!--<input type="file" name="file" id="file">-->
                            <div class="dz-message" style="height:200px;">
                                Arrastre aquí el recurso que desea subir
                            </div>
                            <div class="dropzone-previews"></div>
                            <!--<input type="submit" class="btn btn-success" id="submit" value="Guardar">-->
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
        maxFilesize: 100, 
        acceptedFiles: "image/*,video/mp4,application/pdf",
        // accept: function(file, done) {
        //     alert(file.type);
        //     if (file.type == "image/*") {
        //         alert('Archivo con el formato adecuado');
        //         done();
        //     }
        //     else {
        //         done("No tiene el formato adecuado");
        //         // done(); 
        //     }
        // },
        maxFiles: 1,            
        dictDefaultMessage: 'Arrastra aquí el recurso que deseas subir',            
        //previewTemplate: '  ',            
        init: function() {                
            this.on("success", function(file, response) {                    
                console.log(response);                    
                this.removeFile(file);
                $("#result").append("Recurso cargado correctamente");
                // $('#photo').attr('value',response);    
                // $('#image-upload').hide();   
                // $('#guardar').removeClass('disabled');
            });
            this.on("error", function(file, response) {    
                alert("Hubo un error: " + response);                
                console.log(response);                    
                this.removeFile(file);
                //$('#photo').attr('value',response);    
                //$('#image-upload').hide();   
                //$('#guardar').removeClass('disabled');
            });   
        }
    };
</script>

@endsection

@section('styles')

<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">

@endsection
     