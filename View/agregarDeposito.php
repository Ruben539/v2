<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarDeposito.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Agregar Deposito <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                Datos del deposito a grabar
                            </p>

                            <form method="POST" id="formDeposito" name="formDeposito">
                                <div class="form-group">
                                    <label class="control-label">Fecha a Depositar</label>
                                    <input class="form-control" type="date" name="fecha" id="fecha" required>
                                    <br>
                                    <button type="submit" class="btn btn-success mr-2">Filtar</button>
                                </div>
                            </form>

                            <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <p id="valor" style="color: #cc0000; font-size: 20px;"></p>
                                    <input class="form-control" type="hidden" name="monto" id="monto">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <input class="form-control" type="hidden" name="fecha_deposito" id="fecha_deposito">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Monto Depositado</label>
                                    <input class="form-control" type="text" name="monto_real" id="monto_real">
                                </div>

                                <div class="form-group">
                                    <div class="photo">
                                        <label for="foto">Foto</label>
                                        <div class="prevPhoto">
                                            <span class="delPhoto notBlock">X</span>
                                            <label for="foto"></label>
                                        </div>
                                        <div class="upimg">
                                            <input type="file" name="foto" id="foto">
                                        </div>
                                        <div id="form_alert"></div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary mr-2">Registrar</button>
                                <a class="btn btn-light" href="../Templates/depositos.php">Cancelar</a>
                                <br>
                                <?php if ($alert != "") {  ?>
                                    <div class="btn btn-outline-primary btn-lg w-100 mt-4 mb-0">
                                        <p style="color:#fff;">
                                            <?php echo $alert; ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>
            <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
            <script src="../assets/js/foto.js"></script>
            <script type="text/javascript">
                $('#formDeposito').submit(function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var url = form.attr('action');

                    $.ajax({
                        type: "POST",
                        url: '../Data/BuscarMontoDeposito.php',
                        data: form.serialize(),
                        success: function(data) {
                            $('#valor').html('');
                            $('#valor').append(data);

                            let fecha = document.getElementById('fecha').value
                            document.getElementById('monto').value = data
                            document.getElementById('fecha_deposito').value = fecha

                        }

                    });

                });
            </script>
            <style>
                .prevPhoto {
                    display: flex;
                    justify-content: space-between;
                    width: 250px;
                    height: 250px;
                    border: 1px solid #CCC;
                    position: relative;
                    cursor: pointer;
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center center;
                    margin: auto;
                }

                .prevPhoto label {
                    cursor: pointer;
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    left: 0;
                    z-index: 2;
                }

                .prevPhoto img {
                    width: 100%;
                    height: 100%;
                }

                .upimg,
                .notBlock {
                    display: none !important;
                }

                .errorArchivo {
                    font-size: 16px;
                    font-family: arial;
                    color: #cc0000;
                    text-align: center;
                    font-weight: bold;
                    margin-top: 10px;
                }

                .delPhoto {
                    color: #FFF;
                    display: -webkit-flex;
                    display: -moz-flex;
                    display: -ms-flex;
                    display: -o-flex;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 50%;
                    width: 25px;
                    height: 25px;
                    background: red;
                    position: absolute;
                    right: -10px;
                    top: -10px;
                    z-index: 10;
                }

                #tbl_list_productos img {
                    width: 50px;
                }

                .imgProductoDelete {
                    width: 175px;
                }
            </style>