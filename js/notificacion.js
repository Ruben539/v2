function index() {
    this.ini = function () {
        console.log("iniciando");
        this.getIndicadores();



    }

    this.getIndicadores = function () {

        // Consulta de la sentencia para recuperar los datos para las Notificaciones de los Radiologos
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "10"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idRadiologos").text(parseFloat(datos).toLocaleString() + " " + "Pedidos Pendientes");

            if (datos == 0) {
                //alert("validacion nula");

            } else {

                Swal.fire({
                    /*toast: true,*/
                    position: 'bottom-end',
                    title: 'Paciente Nuevo!',
                    text: 'Tiene un paciente nuevo para asignar',
                    imageUrl: '../assets/images/logo.png',
                    imageWidth: 150,
                    imageHeight: 70,
                    imageAlt: 'Custom image',
                    showConfirmButton: false,
                    timer: 5000,

                });


            }

        });

    }
}

//llave de la primera Clase principal

var oIndex = new index();
setTimeout(function () { oIndex.ini(); }, 100);
