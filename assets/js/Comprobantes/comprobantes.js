
mostrarImgenComprobante = (datos) =>{
    data = datos.split('||');
    //console.log(data[9])
    Swal.fire({
		imageUrl: "../Images/Comprobantes/"+data[9]+"",
		imageWidth: 750,
		imageHeight: 650,
        imageAlt: "Custom image"
		
	})

}