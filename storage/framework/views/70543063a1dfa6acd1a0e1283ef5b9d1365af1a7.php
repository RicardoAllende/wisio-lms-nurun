<?php $__env->startSection('title','Categorías'); ?>
<?php $__env->startSection('cta'); ?>
  <a href="/categories/create" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Categoría</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos las categorias que se encuentran en el sistema</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Categoria </th>
                            <th>Descripción</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                              <td><a href="/categories/<?php echo e($category->id); ?>/"><?php echo e($category->name); ?></a></td>
                              <td><?php echo e($category->description); ?></td>
                              <td><?php echo e($category->created_at); ?></td>
                              <td>
                                  <?php echo Form::open(['method'=>'DELETE','route'=>['categories.destroy',$category->id],'class'=>'form_hidden','style'=>'display:inline;']); ?>

                                     <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                  <?php echo Form::close(); ?>

                              </td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </tbody>
                      </table>
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

<script src="js/sweetalert2.min.js"></script>
<script src="js/method_delete_f.js"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">
<?php $__env->stopSection(); ?>
     

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>