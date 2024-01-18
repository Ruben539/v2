<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-hidden="true" style="height: 650px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Asignar Monto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" name="formUsuario" id="formUsuario" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="seguro">Monto</label>
                        <input type="text" class="form-control" name="monto" id="monto" data-placeholder="Ingrese el monto" style="border: 1px solid #000; color:#000;">
                    </div>
                    <div class="tile-footer">
                        <button id="btnAsignarMonto" class="btn btn-success" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Registrar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="../Templates/pendientesACobrar.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
