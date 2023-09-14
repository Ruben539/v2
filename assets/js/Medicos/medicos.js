

function liberarMedico(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Helpers/eliminarMedico.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Pedido Realizado con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/medicos.php";                          
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


function EliminarDoctor(id){
	Swal.fire({
		title: 'Solicitar eliminación del Medico ?',
		imageUrl: '../assets/images/logo.png',
		text: "Con id Nro. "+id+" del Sistema!",
		imageWidth: 250,
		imageHeight: 250,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Solicitar!'
	}).then((result) => {
		if (result.value) {
			liberarMedico(id);
		}
	})
}



function eliminarDoctor(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Helpers/darBajaMedico.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Solicitud Realizada con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/medicos.php";                          
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


function darBajaDoctor(id){
	Swal.fire({
		title: 'Desea Eliminar el Medico ?',
		imageUrl: '../assets/images/logo.png',
		text: "Eliminar medico "+id+" del Sistema!",
		imageWidth: 250,
		imageHeight: 250,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
		if (result.value) {
			eliminarDoctor(id);
		}
	})
}


function activarUsuario(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"Helpers/Activar_Usu.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Reestablecido con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "usuario";                          
					}
				})
				
			}else{
				Swal.fire({
					type: 'error',
					title: 'Error al Reestablecer',                          
				});	
			}
		}
	});
}

function activarDatos(id){
	Swal.fire({
		title: 'Desea Reestablecer el Usuario ?',
		text: "Reestablecer Usuario "+id+" del Sistema!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Reestablecer!'
	}).then((result) => {
		if (result.value) {
			activarUsuario(id);
		}
	})
}

