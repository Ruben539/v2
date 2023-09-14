

function liberarGasto(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Helpers/cancelarGasto.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Pedido Realizado con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/gastos.php";                          
					}
				})
				
			}else{
				Swal.fire({
					type: 'error',
					title: 'Error al Eliminar',                          
				});
			}
		}
	});
}


function darBajaGasto(id){
	Swal.fire({
		title: 'Deseaeliminar el Gasto ?',
		imageUrl: '../assets/images/logo.png',
		text: "Con id Nro. "+id+" del Sistema!",
		imageWidth: 250,
		imageHeight: 250,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
		if (result.value) {
			liberarGasto(id);
		}
	})
}