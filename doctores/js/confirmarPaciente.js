

function liberarPaciente(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Controllers/confirmarPaciente.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Paciente Atendido con exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/dashboardDoctores.php";                          
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


function confirmarPaciente(id){
	Swal.fire({
		title: 'Desea confirmar la atención ?',
		imageUrl: '../../assets/images/logo.png',
		text: "Con id Nro. "+id+" del Sistema!",
		imageWidth: 250,
		imageHeight: 250,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Confirmar!'
	}).then((result) => {
		if (result.value) {
			liberarPaciente(id);
		}
	})
}







