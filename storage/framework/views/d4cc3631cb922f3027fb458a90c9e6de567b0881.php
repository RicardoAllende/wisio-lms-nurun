

<?php $__env->startSection('title','Usuarios'); ?>
<?php $__env->startSection('cta'); ?>
  <a href="/users/<?php echo e($user->id); ?>/edit" class="btn btn-primary "><i class='fa fa-edit'></i> Editar Usuario</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos de Usuario</h5>
                
            </div>

		<div class="contact-box">
            
            <div class="col-sm-4">
                <div class="text-center">
                    <img alt="image" class="img-circle m-t-xs img-responsive" src="/<?php echo e($user->photo); ?>">
                    <div class="m-t-xs font-bold">Usuario</div>
                </div>
            </div>
            <div class="col-sm-8">
                <h3><strong><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></strong></h3>
                <p><i class="fa fa-envelope"></i> <?php echo e($user->email); ?></p>
                <p><i class="fa fa-<?php echo e($user->sex); ?>"></i> <?php echo e($user->sex); ?></p>
                <p><i class="fa fa-birthday-cake"></i> <?php echo e($user->birth_day); ?></p>
                
                
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