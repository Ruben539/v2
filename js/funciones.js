function index() {
    this.ini = function () {
        console.log("iniciando");
        this.getIndicadores();



    }

    this.getIndicadores = function () {
        //Consulta de Vendidos al servisor de parte del Cliente Para ver el Total Pacientes
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "1"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idPacientePaz").text(parseFloat(datos).toLocaleString());
        });

        //Consulta de la Sentencia para recuperar los datos Obtenidos
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "2"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idPacienteDiax").text(parseFloat(datos).toLocaleString());
        });

        //Consulta de la Sentencia para recuperar los datos de Pacientes por Doctor en Espera
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "3"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idTotalPacientes").text(parseFloat(datos).toLocaleString());
        });

        //Consulta de la Sentencia para recuperar los datos de Pacientes por Doctor en Atendidos
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "4"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idMontoDiax").text(parseFloat(datos).toLocaleString() + " " + ".GS");
        });

        //Consulta de la Sentencia para recuperar los datos de Pacientes por Doctor en Atendidos
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "5"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idMontoPaz").text(parseFloat(datos).toLocaleString() + " " + ".GS");
        });

        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "6"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idTotalMonto").text(parseFloat(datos).toLocaleString() + " " + ".GS");
        });


        // Consulta de la sentencia para recuperar los datos para las Notificaciones
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "7"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idNotificacion").text(parseFloat(datos).toLocaleString() + " " + "Pedidos Pendientes");

            if (datos == 0) {
                //alert("validacion nula");

            } else {

                Swal.fire({
                    /*toast: true,*/
                    position: 'bottom-end',
                    title: 'Solicitud Nueva!',
                    text: 'Tiene un nuevo Pedido de cancelación de Orden',
                    imageUrl: '../assets/images/logo.png',
                    imageWidth: 150,
                    imageHeight: 70,
                    imageAlt: 'Custom image',
                    showConfirmButton: false,
                    timer: 5000,

                });


            }

        });


        // Consulta de la sentencia para recuperar los datos para las Notificaciones
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "8"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idMedicos").text(parseFloat(datos).toLocaleString() + " " + "Pedidos Pendientes");

            if (datos == 0) {
                //alert("validacion nula");

            } else {

                Swal.fire({
                    /*toast: true,*/
                    position: 'bottom-end',
                    title: 'Solicitud Nueva!',
                    text: 'Tiene un pedido nuevo de Eliminación de Gasto',
                    imageUrl: '../assets/images/logo.png',
                    imageWidth: 150,
                    imageHeight: 70,
                    imageAlt: 'Custom image',
                    showConfirmButton: false,
                    timer: 5000,

                });


            }

        });

        // Consulta de la sentencia para recuperar los datos para las Notificaciones
        $.ajax({
            statusCode: {
                404: function () {
                    console.log("Esta Pagina no Existe");
                }
            },
            url: '../Libraries/servidor.php',
            method: 'POST',
            data: {
                rq: "9"
            }
        }).done(function (datos) {
            //Logica de respuesta  de los datos
            $("#idGastos").text(parseFloat(datos).toLocaleString() + " " + "Pedidos Pendientes");

            if (datos == 0) {
                //alert("validacion nula");

            } else {

                Swal.fire({
                    /*toast: true,*/
                    position: 'bottom-end',
                    title: 'Solicitud Nueva!',
                    text: 'Tiene un pedido nuevo de Eliminación de medico',
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
