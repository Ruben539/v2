<?php
require_once("../includes/header_admin.php");

?>
<link rel="stylesheet" type="text/css" href="css/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/home.css">

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <?php
            require_once('../Models/conexion.php');

            $SqlEventos   = ("SELECT DISTINCT(a.id),a.nombre,a.agenda, a.fecha_inicio, a.fecha_fin, a.color_evento, m.id as doctor_id, m.nombre as medico
             FROM agendamiento a INNER JOIN medicos m ON m.id = a.doctor_id
            WHERE a.estatus = 1");
            $resulEventos = mysqli_query($conection, $SqlEventos);

            ?>
            <div class="mt-5"></div>

            <div class="container">
              <div class="row">
                <div class="col msjs">
                  <?php
                  include('msjs.php');
                  ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-3">
                  <h3 class="text-center" id="title">Calendario de Agendamiento</h3>
                </div>
              </div>
            </div>



            <div id="calendar"></div>


            <?php
            include('modalNuevoEvento.php');
            include('modalUpdateEvento.php');
            ?>
          </div>
        </div>
      </div>

      <?php include('../includes/footer_admin.php'); ?>


      <script src="js/jquery-3.0.0.min.js"> </script>
     
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>

      <script type="text/javascript" src="js/moment.min.js"></script>
      <script type="text/javascript" src="js/fullcalendar.min.js"></script>
      <script src='locales/es.js'></script>

      <script type="text/javascript">
        $(document).ready(function() {
          $("#calendar").fullCalendar({
            header: {
              left: "prev,next today",
              center: "title",
              right: "month,agendaWeek,agendaDay"
            },

            locale: 'es',

            defaultView: "month",
            navLinks: true,
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: false,

            //Nuevo Evento
            select: function(start, end) {
              $("#exampleModal").modal();
              $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY'));

              var valorFechaFin = end.format("DD-MM-YYYY");
              var F_final = moment(valorFechaFin, "DD-MM-YYYY").subtract(1, 'days').format('DD-MM-YYYY'); //Le resto 1 dia
              $('input[name=fecha_fin').val(F_final);

            },

            events: [
              <?php
              while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?> {
                  _id: '<?php echo $dataEvento['id']; ?>',
                  title: '<?php echo $dataEvento['nombre']; ?>',
                  subtitle: '<?php echo $dataEvento['agenda']; ?>',
                  start: '<?php echo $dataEvento['fecha_inicio']; ?>',
                  end: '<?php echo $dataEvento['fecha_fin']; ?>',
                  color: '<?php echo $dataEvento['color_evento']; ?>'
                },
              <?php } ?>
            ],


            //Eliminar Evento
            eventRender: function(event, element) {
              element
                .find(".fc-content")
                .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");

              //Eliminar evento
              element.find(".closeon").on("click", function() {

                var pregunta = confirm("Deseas Borrar este Evento?");
                if (pregunta) {

                  $("#calendar").fullCalendar("removeEvents", event._id);

                  $.ajax({
                    type: "POST",
                    url: 'deleteEvento.php',
                    data: {
                      id: event._id
                    },
                    success: function(datos) {
                      $(".alert-danger").show();

                      setTimeout(function() {
                        $(".alert-danger").slideUp(500);
                      }, 3000);

                    }
                  });
                }
              });
            },


            //Moviendo Evento Drag - Drop
            eventDrop: function(event, delta) {
              var idEvento = event._id;
              var start = (event.start.format('DD-MM-YYYY'));
              var end = (event.end.format("DD-MM-YYYY"));

              $.ajax({
                url: 'drag_drop_evento.php',
                data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
                type: "POST",
                success: function(response) {
                  // $("#respuesta").html(response);
                }
              });
            },

            //Modificar Evento del Calendario 
            eventClick: function(event) {
              var idEvento = event._id;
              $('input[name=idEvento').val(idEvento);
              $('input[name=nombre').val(event.title);
              $('input[name=agenda').val(event.subtitle);
              $('input[name=fecha_inicio').val(event.start.format('DD-MM-YYYY'));
              $('input[name=fecha_fin').val(event.end.format("DD-MM-YYYY"));

              $("#modalUpdateEvento").modal();
            },


          });


          //Oculta mensajes de Notificacion
          setTimeout(function() {
            $(".alert").slideUp(300);
          }, 3000);


        });
      </script>


      <!--------- WEB DEVELOPER ------>
      <!--------- URIAN VIERA   ----------->
      <!--------- PORTAFOLIO:  https://blogangular-c7858.web.app  -------->