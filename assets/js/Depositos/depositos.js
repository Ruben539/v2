mostrarImgenDeposito = (datos) =>{
    data = datos.split('||');
   
    Swal.fire({
		imageUrl: "../Images/IngresoDiario/"+data[0]+"",
		imageWidth: 750,
		imageHeight: 650,
        imageAlt: "Custom image"
		
	})

}