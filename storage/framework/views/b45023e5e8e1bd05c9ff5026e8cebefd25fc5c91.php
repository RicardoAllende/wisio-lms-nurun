<?php $__env->startSection('title','Cursos'); ?>
<?php $__env->startSection('cta'); ?>
  <a href="/courses/<?php echo e($course->id); ?>/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Curso</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Curso</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="m-t-xs img-responsive" src="/<?php echo e($course->featured_image); ?>">
                    <div class="m-t-xs font-bold">Curso</div>
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong><?php echo e($course->name); ?></strong></h3>
                <p> <?php echo e($course->description); ?></p>
                
                
                
            </div>
            <div class="clearfix"></div>
                
        </div>
        </div>
      </div>
	</div>
</div>

                        


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>