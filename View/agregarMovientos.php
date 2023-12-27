<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarMovimientos.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Agregar Gasto <i class="typcn typcn-calculator"></i></h4>
                    <p class="card-description text-center">
                        Datos del gasto a grabar
                    </p>
                    <form  method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-5" style="margin-left: 10px; margin-right: 10px;">
                                <div class="form-group row">
                                    <label class="control-label" for="forma_pago">Forma de Pago</label>
                                    <select name="forma_pago" id="forma_pago" class="form-control" style="border: 1px solid #000;">
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-5" id="mov">
                                <div class="form-group row">
                                    <label class="control-label">Nro de Transacción</label>
                                    <input class="form-control" type="text" name="nro_cheque" id="nro_cheque" placeholder="Ingrese la el numero de Transacción" style="border: 1px solid #000;">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label class="control-label" for="tipo_salida">Tipo de Movimiento</label>
                                    <select name="tipo_salida" id="tipo_salida" class="form-control" style="border: 1px solid #000;">
                                        <option value="Ingreso">Ingreso</option>
                                        <option value="Egreso">Egreso</option>
                                        <option value="Deposito">Deposito Bancario</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5" style="margin-left: 10px; margin-right: 10px;">
                                <div class="form-group row">
                                    <label class="control-label">Cantidad de Importe</label>
                                    <input class="form-control" type="text" name="monto" id="monto" placeholder="Ingrese el monto" style="border: 1px solid #000;">
                                </div>
                            </div>


                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label class="control-label" for="fecha">Proveedor</label>
                                    <input type="text" name="proveedor" id="proveedor" class="form-control" style="border: 1px solid #000;">
                                </div>
                            </div>


                            <div class="col-md-5" style="margin-left: 10px; margin-right: 10px;">
                                <div class="form-group row">
                                    <label class="control-label" for="concepto">Concepto de Pago</label>
                                    <textarea type="text" name="concepto" id="concepto" class="form-control" placeholder="Ingrese el concepto del Gasto" style="max-height: 145px; border: 1px solid #000;">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-5">
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
                                </button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Templates/movimientosFinacieros.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>

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

<script type="text/javascript">
    const valor = document.querySelector('#forma_pago');
    document.getElementById('mov').style.display = 'none';

    console.log(valor);

    /*OBTENER VALOR SELECCIONADO DE LA LISTA DE OPCIONES*/
    valor.addEventListener('change', function() {
        let valorOptions = valor.value;

        var opctionSelect = valor.options[valor.selectedIndex];

        console.log('Opciones: ' + opctionSelect.text);
        console.log('Opciones: ' + opctionSelect.value);

        if (opctionSelect.value === 'Cheque') {
            document.getElementById('mov').style.display = 'block';
        } else if (opctionSelect.value === 'Transferencia') {
            document.getElementById('mov').style.display = 'block';
        } else {
            document.getElementById('mov').style.display = 'none';
        }
    });
</script>
<style>
    .prevPhoto {
        display: flex;
        justify-content: space-between;
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