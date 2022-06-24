<!-- Modal form to edit -->
<div id="editVendedor" class="modal fade" role="dialog" tabindex="-1">

    <form class="form-horizontal" role="form" onsubmit="preventDefault()">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar vendedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-12">Id:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="vendedor_id" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-12" for="nombres">Apellido y nombres</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombres" name="nombres">
                        </div>
                    </div>

                    <div class="form-group mt-5 mb-5">
                        
                        <div class="col-sm-10" id="errores">
                         
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-primary" onclick="actualizar()">
                        Actualizar
                    </button>
                </div>
            </div>

        </div>

    </form>
</div>
