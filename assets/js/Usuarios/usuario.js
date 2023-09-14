

function liberarUsuario(id){
	cadena = "id=" + id;

	$.ajax({
		type:"POST",
		url:"../Helpers/eliminarUsuario.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Eliminado con Exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/usuarios.php";                          
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


function EliminarUsuario(id){
	Swal.fire({
		title: 'Desea Eliminar el Usuario ?',
		imageUrl: '../assets/images/logo.png',
		text: "Eliminar Usuario "+id+" del Sistema!",
		imageWidth: 250,
		imageHeight: 250,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
		if (result.value) {
			liberarUsuario(id);
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

