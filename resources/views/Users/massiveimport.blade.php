@extends('layouts.app')

@section('title','Asignación masiva de usuarios')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a href="/storage/plantilla_subir_usuarios.csv" download="Plantilla_subir_usuarios_wisio_lms.csv" class="btn btn-info">Descargar plantilla</a>
                <!--<div class="ibox-title">
                    <h5>Asignación masiva de usuarios</h5>
                </div>-->
                <h1>Asignación masiva de usuarios</h1>
                <div class="form-group" id="formUpload">
                    {!! Form::label('photo_label', 'Archivo:',['class'=>'control-label col-sm-2']); !!}
                    {!! Form::open([ 'route' => 'uploaduserscsv' , 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                    <div class="dz-message" style="height:200px;">
                        Arrastre su archivo aquí...
                    </div>
                    <div class="dropzone-previews"></div>
                    <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                    {!! Form::close() !!}
                </div>
                </div>
                <!--<<div class="ibox-footer">
                    
                </div>-->
            </div>
        </div>
    </div>
</div>

                        


@endsection

@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
<script type="text/javascript">

      Dropzone.options.imageUpload  = {            
                paramName: "file", 
                // The name that will be used to transfer the file            
                maxFilesize: 2,            
                acceptedFiles: null,            
                maxFiles: 1,            
                dictDefaultMessage: 'Arrastra aquí el archivo de usuarios',            
                //previewTemplate: '  ',            
                init: function() {                
                  this.on("success", function(file, response) {                    
                    console.log(response);                    
                    this.removeFile(file);
                    //$('#photo').attr('value',response);
                    $("#formUpload").html(response);   
                    //$('#guardar').removeClass('disabled');
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
     