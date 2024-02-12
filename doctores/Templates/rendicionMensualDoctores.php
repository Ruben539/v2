<?php
require_once("../includes/header_admin.php");
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4>Rendicion de Medicos <i class="typcn typcn-flow-children"></i> </h4>

                        <form class="row" method="POST" id="formMedicos">
                            <div class="col-md-5">
                                <div class="widget-small">
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="widget-small">
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                </div>
                            </div>         

                            <div class="col-md-2">

                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>Filtrar

                            </div>
                    </div>
                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="table-responsive">
                                    <table id="tablaResultado" class="table table-striped table-bordered table-condensed" style="width:100%">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>





        <?php include('../includes/footer_admin.php'); ?>
        <script type="text/javascript">
            $('#formMedicos').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: '../Data/BuscarRendicionMedico.php',
                    data: form.serialize(),
                    success: function(data) {
                        $('#tablaResultado').html('');
                        $('#tablaResultado').append(data);
                    }

                });

            });
        </script>