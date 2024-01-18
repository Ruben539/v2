

function liberarEstudio(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Helpers/eliminarEstudio.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Pedido Realizado con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/estudios.php";                          
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


function EliminarEstudio(id){
	Swal.fire({
		title: 'Desea eliminar el Estudio ?',
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
			liberarEstudio(id);
		}
	})
}


function asignarMonto(datos){
	console.log(datos)
	d = datos.split('||');
	
	$('#id').val(d[0]);
	$('#monto').val(d[6]);
		
}

function confirmacionMontoAsignado(){

	id=$('#id').val();
	monto=$('#monto').val();
	

	cadena = "id=" + id +
	"&monto=" + monto;
	$.ajax({
		type:"POST",
		url:"../Helpers/AsignarMontoEstudio.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Agregado con exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/estudios.php";                          
					}
				})

			}else{
				Swal.fire({
					type: 'error',
					title: 'Error al Agregar',                          
				});
			}
		}
	});
}






