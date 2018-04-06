$(document).ready(function() {
	$('.btn_delete').click(function() {
		var form = $(this).parent();
		swal({
		  title: '¿Estás seguro?',
		  text: "Se eliminará un registro",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si',
		  cancelButtonText: 'No, cancelar',
		  confirmButtonClass: 'btn btn-success',
		  cancelButtonClass: 'btn btn-danger',
		  buttonsStyling: false
		}).then(function () {
			form.submit();
		  swal(
		    'Borrado!',
		    'El registro se ha borrado correctamente',
		    'success'
		  )
		}, function (dismiss) {
		  // dismiss can be 'cancel', 'overlay',
		  // 'close', and 'timer'
		  if (dismiss === 'cancel') {
		    swal(
		      'Cancelado',
		      'Has cancelado la operación',
		      'error'
		    )
		  }
		})
	});
});