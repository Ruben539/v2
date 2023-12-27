function editarDatosFactura(datos){
	console.log(datos)
	d = datos.split('||');

	

	$('#id').val(d[0]);
	$('#ruc').val(d[1]);
	$('#razon_social').val(d[2]);
	$('#estudio').val(d[3]);
	
}

function confirmarDatosFacturacion(){

	id=$('#id').val();
	forma_pago_id=$('#forma_pago_id').val();
	id_referente=$('#id_referente').val();
	forma_pago_id_2=$('#forma_pago_id_2').val();
	monto_2=$('#monto_2').val();
	
	


	cadena = "id=" + id +
	"&forma_pago_id=" + forma_pago_id +
	"&id_referente=" + id_referente +
	"&forma_pago_id_2=" + forma_pago_id_2 +
	"&monto_2=" + monto_2;
	
;


	$.ajax({
		type:"POST",
		url:"../Helpers/confirmarFacturacion.php",
		data:cadena,
		success: function(r){
			if(r == 1){
				Swal.fire({
					type: 'success',                          
					title: 'Facturado con exito!'
				}).then((result) => {
					if (result.value) {
						window.location.href = "../Templates/pendientesACobrar.php";                          
					}
				})

			}else{
				Swal.fire({
					type: 'error',
					title: 'Error al Facturar',                          
				});
			}
		}
	});
}