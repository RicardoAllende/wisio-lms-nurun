<?php $__env->startSection('title','Categorías'); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar categoria</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                          <?php if(!isset($category)): ?>
                          <?php echo Form::open(['url' => '/categories','class'=>'form-horizontal','method' => 'post']); ?>

                          <?php else: ?>
                          <?php echo Form::model($category,['url' => '/categories/'.$category->id,'class'=>'form-horizontal','method' => 'put']); ?>

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
                            <!-- <div class="form-group">
                              <?php echo Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::file('featured_image',null,['class'=>'form-control','placeholder'=>'']); ?>

                              </div>
                            </div> -->
                             <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/categories" class="btn btn-default">Cancelar</a>
                             <?php echo Form::hidden('featured_image',null,['class'=>'form-control','placeholder'=>'','id'=>'featured_image']); ?>

                             <?php echo Form::submit('Guardar',['class'=>'btn btn-primary']); ?>

                            </div>
                          </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="form-group">
                      <?php echo Form::label('featured_label', 'Imagen:',['class'=>'control-label col-sm-2']);; ?>

                      <?php echo Form::open([ 'url' => [ '/categories/uploadImage' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]); ?>

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
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

<link rel="stylesheet" type="text/css" href="/css/plugins/dropzone/basic.css">

<?php $__env->stopSection(); ?>
     
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>