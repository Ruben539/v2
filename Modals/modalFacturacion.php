<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-hidden="true" style="height: 650px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Confirmar Facturación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" name="formUsuario" id="formUsuario" class="form-horizontal">
                    <p><b> Nro de Ticket:</b> <input type="text" name="id" id="id" style="margin-left: 20px; border: none; font-size:16px;"></p>
                    <div class="info text-center" style="width: 470px;
                    height: 150px; border: 1px solid #1571e6;">
                        <p><b>Cedula :</b><input type="text" id="ruc" name="ruc" style="border: none; width: 100px;"></p>
                        <hr>
                        <p> <b>Nombre :</b> <input type="text" id="razon_social" name="razon_social" style="border: none; width: 100px;"><span></span> </p>
                        <hr>
                        <p><b>Estudio Realizado :</b> <input type="text" id="estudio" name="estudio" style="border: none; width: 145px; margin-bottom: 10px;"><span></span></p>
                    </div>

                    <div class="form-group">
                        <label for="seguro">Forma de Pago</label>
                        <select class="chosen form-control" name="forma_pago_id" id="forma_pago_id" required data-placeholder="Seleccione un Seguro" style="border: 1px solid #000; color:#000;">
                            <option value=""></option>
                            <?php
                            $raw_results4 = mysqli_query($conection, "select * from forma_pagos where estatus = 1") or die(mysqli_error($conection));
                            while ($results = mysqli_fetch_array($raw_results4)) {
                            ?>

                                <option value=" <?php echo $results['id'] ?> ">
                                    <?php echo $results['descripcion']; ?>
                                </option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="seguro">Medico Comisionista</label>
                        <select class="chosen form-control" name="id_referente" id="id_referente" required data-placeholder="Seleccione un Seguro" style="border: 1px solid #000; color:#000;">
                            <option value=""></option>
                            <?php
                            $raw_results4 = mysqli_query($conection, "select * from comisionista where estatus = 1") or die(mysqli_error($conection));
                            while ($results = mysqli_fetch_array($raw_results4)) {
                            ?>

                                <option value=" <?php echo $results['id'] ?> ">
                                    <?php echo $results['nombre']; ?>
                                </option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="" id="combinado">
                                Pago Combinado
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="pago">
                        <label for="seguro">Forma de Pago</label>
                        <select class="chosen form-control" name="forma_pago_id_2" id="forma_pago_id_2" required data-placeholder="Seleccione un Seguro" style="border: 1px solid #000; color:#000;">
                            <option value=""></option>
                            <?php
                            $raw_results4 = mysqli_query($conection, "select * from forma_pagos where estatus = 1") or die(mysqli_error($conection));
                            while ($results = mysqli_fetch_array($raw_results4)) {
                            ?>

                                <option value=" <?php echo $results['id'] ?> ">
                                    <?php echo $results['descripcion']; ?>
                                </option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group" id="monto">
                        <label for="seguro">Monto</label>
                        <input type="text" class="form-control" name="monto_2" id="monto_2" data-placeholder="Ingrese el monto" style="border: 1px solid #000; color:#000;">
                    </div>
                    <div class="tile-footer">
                        <button id="btnEditarUsu" class="btn btn-success" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Registrar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="../Templates/pendientesACobrar.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let pago = document.getElementById('combinado');


    pago.checked = false;
    document.getElementById('pago').style.display = 'none';
    document.getElementById('monto').style.display = 'none';

    pago.addEventListener('click', (e) => {
        if (e.target.checked) {

            document.getElementById('pago').style.display = 'block';
            document.getElementById('monto').style.display = 'block';

        } else {
            document.getElementById('pago').style.display = 'none';
            document.getElementById('monto').style.display = 'none';
        }
    })
</script>