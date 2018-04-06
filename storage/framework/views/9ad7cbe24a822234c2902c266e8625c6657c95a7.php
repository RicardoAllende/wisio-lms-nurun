<?php $__env->startSection('title','Usuarios'); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Formulario para crear/editar usuario</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">
                        <?php if(!isset($user)): ?>
                          <?php echo Form::open(['url' => '/users','class'=>'form-horizontal','method' => 'post']); ?>

                        <?php else: ?>
                          <?php echo Form::model($user,['url' => '/users/'.$user->id,'class'=>'form-horizontal','method' => 'put']); ?>

                        <?php endif; ?>
                            <div class="form-group">
                              <?php echo Form::label('nombre', 'Nombre:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10">
                               <?php echo Form::text('first_name',null,['class'=>'form-control','placeholder'=>'Nombre']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('apellidos', 'Apellidos:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Apellidos']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('email', 'Email:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::email('email',null,['class'=>'form-control','placeholder'=>'Email']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('birthday', 'Fecha de nacimiento:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::date('birth_day',null,['class'=>'form-control','placeholder'=>'']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('sex', 'Sexo',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                               <?php echo Form::select('sex',[''=>'Seleccione una opcion','male'=>'Masculino','female'=>'Femenino'],null,['class'=>'form-control']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('typeuser', 'Tipo de Usuario:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                               <?php echo Form::select('type',[''=>'Seleccione una opcion','0'=>'Administrador','1'=>'Usuario'],null,['class'=>'form-control']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('source_label', 'Source:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::text('source',null,['class'=>'form-control','placeholder'=>'Source']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('token_label', 'Token:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::text('source_token',null,['class'=>'form-control','placeholder'=>'Source_token']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('lastaccess_label', 'Ultimo acceso:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                                <?php echo Form::date('last_access',null,['class'=>'form-control','placeholder'=>'']); ?>

                              </div>
                            </div>
                            <div class="form-group">
                              <?php echo Form::label('enabled_label', 'Habilitado:',['class'=>'control-label col-sm-2']);; ?>

                              <div class="col-sm-10"> 
                               <?php echo Form::select('enable',[''=>'Seleccione una opcion','0'=>'Activo','1'=>'Desactivado'],null,['class'=>'form-control']); ?>

                              </div>
                            </div>
                            <div class="form-group"> 
                            <div class="col-sm-offset-2 col-sm-10">
                            <a href="/users" class="btn btn-default">Cancelar</a>
                            <?php echo Form::hidden('photo',null,['class'=>'form-control','placeholder'=>'','id'=>'photo']); ?>


                             <?php echo Form::submit('Guardar',['class'=>'btn btn-primary']); ?>

                            </div>
                          </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="form-group">
                      <?php echo Form::label('photo_label', 'Imagen:',['class'=>'control-label col-sm-2']);; ?>

                      <?php echo Form::open([ 'url' => [ '/users/uploadImage' ], 'files' => true, 'class' => 'dropzone', 'id' => 'image-upload' ]); ?>

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
                    $('#photo').attr('value',response);    
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