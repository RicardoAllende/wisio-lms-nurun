<?php $__env->startSection('content'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos los usuarios que se encuentran en el sistema</h5>
                        
                    </div>
                    <div class="ibox-content">
                    	<div class="table-responsive">
                    		<table class="table table-striped table-bordered table-hover dataTables">
                    		<thead>
                    			<tr><th>Nombre del Usuario</th><th>Nombre</th></tr>
                    		</thead>
                    		<tbody>
                    			<tr>
                    				<td>Fulanito </td>
                    				<td>Fulanito </td>
                    			</tr>
                    		</tbody>
                    	</table>
                    	</div>
                    	
                    </div>
                    <div class="ibox-footer">
                    	Footer
                    </div>
                </div>
            	</div>
			</div>
</div>

                        


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript" src="/js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.dataTables').DataTable();
	});
</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="/css/plugins/dataTables/datatables.min.css">

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>