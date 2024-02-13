</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="#" class="text-muted" target="_blank">Sistema de Registro de Pacientes</a>. Derechos Reservados de la Clinica.</span>

            </div>
        </div>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>


</body>

</html>

<script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/sweetalert2.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../assets/vendors/chart.js/Chart.min.js"></script>
<script src="../assets/js/off-canvas.js"></script>
<script src="../assets/js/hoverable-collapse.js"></script>
<script src="../assets/js/template.js"></script>
<script src="../assets/js/settings.js"></script>
<script src="../assets/js/todolist.js"></script>
<script src="../js/funciones.js"></script>
<?php if($_SESSION['rol'] == 5){?>
        <script src="../js/notificacion.js"></script>
        <?php }?>
<script type="text/javascript">
    $(document).ready(function() {
        tabla = $("#tabla").DataTable({
            "columnDefs": [{
                "target": 1,
                "data": null
            }],

            //Para cambiar el lenguaje a español
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "1",
                    "sLast": ">>",
                    "sNext": ">",
                    "sPrevious": "<"
                },
                "sProcessing": "Procesando...",
            }
        });



    });
</script>