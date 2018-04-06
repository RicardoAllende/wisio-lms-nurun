<?php $__env->startSection('title','Cursos'); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar curso</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                        <?php if(!isset($course)): ?>
                        <?php echo Form::open(['url' => '/courses','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']); ?>

                      <?php else: ?>
                        <?php echo Form::model($course,['url' => '/courses/'.$course->id,'class'=>'form-horizontal','method' => 'put']); ?>

                      <?php endif; ?>
                          <div class="form-group">
                            <?php echo Form::label('nombre', 'Nombre:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10">
                             <?php echo Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('descripcion_label', 'Descripción:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                              <?php echo Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('datestart_label', 'Fecha de inicio:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                              <?php echo Form::date('date_start',null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('dateend_label', 'Fecha de fin:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                              <?php echo Form::date('date_end',null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <!-- <div class="form-group">
                            <?php echo Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                              <?php echo Form::text('featured_image',null,['class'=>'form-control','placeholder'=>'']); ?>

                            </div>
                          </div> -->
                          <div class="form-group">
                            <?php echo Form::label('length_label', 'Duración:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-5"> 
                              <?php echo Form::text('amount',null,['class'=>'form-control','placeholder'=>'']); ?>

                            </div>
                            <div class="col-sm-5"> 
                              <?php echo Form::select('unit',[''=>'Seleccione una opcion','minutes'=>'Minutos','hours'=>'Horas','days'=>'Días'],null,['class'=>'form-control','placeholder'=>'']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('featured_label', 'Destacado:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                             <?php echo Form::select('featured',[''=>'Seleccione una opcion','0'=>'No','1'=>'Si'],null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('weight_label', 'Prioridad:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                             <?php echo Form::select('weight',[''=>'Seleccione una opcion','1'=>'1','2'=>'2','3'=>'3'],null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('difficulty_label', 'Dificultad',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                             <?php echo Form::select('difficulty',[''=>'Seleccione una opcion','básico'=>'básico','intermedio'=>'intermedio','avanzado'=>'avanzado','experto'=>'experto'],null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <div class="form-group">
                            <?php echo Form::label('category_label', 'Categoría:',['class'=>'control-label col-sm-2']);; ?>

                            <div class="col-sm-10"> 
                             <?php echo Form::select('category_id',[''=>'Seleccione una opción']+App\Category::pluck('name','id')->toArray(),null,['class'=>'form-control']); ?>

                            </div>
                          </div>
                          <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/courses" class="btn btn-default">Cancelar</a>
                            <?php echo Form::hidden('featured_image',null,['class'=>'form-control','placeholder'=>'','id'=>'featured_image']); ?>

                             <?php echo Form::submit('Guardar',['class'=>'btn btn-primary disabled','id'=>'guardar']); ?>

                            </div>
                          </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="form-group">
                      <?php echo Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']);; ?>

                      <?php echo Form::open([ 'url' => [ '/courses/uploadImage' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]); ?>

                      <div class="dz-message" style="height:200px;">
                          Arrastre su imagen aquí...
                      </div>
                      <div class="dropzone-previews"></div>
                      <!-- <button type="submit" class="btn btn-success" id="submit">Guardar</button> -->
                      <?php echo Form::close(); ?>

                  </div>
                      
                    </div>
                    <div class="ibox-footer">
                      
                    </div>
                </div>
              </div>
      </div>
</div>

                        


<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>

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
                    $('#featured_image').attr('value',response);    
                    $('#image-upload').hide();   
                    $('#guardar').removeClass('disabled');

                  });            
                }        
              };
     

       // $(document).ready(function (){

       //      Dropzone.options.imageUpload = {
       //          paramName: "file",
       //          maxFilesize:6,
       //          uploadMultiple: false,
       //          acceptedFiles: "image/*",
       //          maxFiles: 1,
       //          init: function() {
                  
       //            this.on("success", function(file){
       //                console.log('Se cargó la imagen', file, file.xhr.responseText);                    
       //              this.removeFile(file);   
       //            });
       //          }
       //      };

            
       //  });
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">

<?php $__env->stopSection(); ?>
     
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>