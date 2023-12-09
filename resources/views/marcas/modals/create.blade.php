<!-- Modal para crear un nuevo usuario -->
<div class="modal fade" id="crear_marca_modal" tabindex="-1" role="dialog" aria-labelledby="crear_marca_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Marcas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crear_marca_formulario" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    
                    <div class="form-group">
                        <label>Nombre de marca</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="crear_marca_formulario_cancelar">Cerrar</button>
                <button type="button" class="btn btn-primary" id="crear_marca_formulario_mandar">Guardar Categoría</button>
            </div>
        </div>
    </div>
</div>
