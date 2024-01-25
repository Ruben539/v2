<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarFotoDeposito.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Agregar foto del Deposito <i class="typcn typcn-calculator"></i></h4>
                    <p class="card-description text-center">
                        Imagen del desposito realizado
                    </p>
                    <form  method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-group row">
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
                            </div>
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $_SESSION['nombre']; ?>">
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
                                </button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Templates/depositos.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>

                            </div>


                        </div>
                    </form>
                    <br>
                    <?php if ($alert != "") {  ?>
                        <div class="btn btn-outline-primary btn-lg w-100 mt-4 mb-0">
                            <p style="color:#fff;">
                                <?php echo $alert; ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer_admin.php'); ?>
<script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/foto.js"></script>

<style>
    .prevPhoto {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 350px;
        height: 350px;
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