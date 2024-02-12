function index(){
    this.ini = function(){
       console.log('Iniciando funcion de alerta')
        this.getIndicadores(); 

    }

    this.getIndicadores = function(){
        //TODO: Funcion ajax para mostrar la notificacion de pacientes para los doctores.
        $.ajax({
            statusCode:{
                404:function(){
                    console.log("Esta Pagina no Existe");
                }
            },
            url:'../Library/servidor.php',
            method:'POST',
            data:{
                rq:"1"
            }
            }).done(function(datos){
            //Logica de respuesta  de los datos
            $("#idPacientes").text(parseFloat(datos).toLocaleString()+" "+"Pedidos Pendientes");
            
            if (datos == 0) {
            //alert("validacion nula");
            
            }else{
            
            Swal.fire({
            /*toast: true,*/
            position: 'bottom-end',
            title: 'Tiene un nuevo Paciente!',
            text: 'Se le ha asignado un nuevo paciente',
            imageUrl: '../../assets/images/logo.png',
            imageWidth: 150,
            imageHeight: 100,
            imageAlt: 'Custom image',
            showConfirmButton: false,
            timer: 5000, 
            
            });
            
            
            }
            
            });
       
    }
}
var oIndex = new index();

(function  (){
    oIndex.ini();
})();

// setTimeout(
//     async  function () {
//         await oIndex.ini();
// },
// 100);

