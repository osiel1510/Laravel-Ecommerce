<!-- Modal para crear un nuevo usuario -->
<div class="modal fade" id="crear_categoria_modal" tabindex="-1" role="dialog" aria-labelledby="crear_categoria_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Categorías</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crear_categoria_formulario">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label>Nombre de categoría</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="crear_categoria_formulario_cancelar">Cerrar</button>
                <button type="button" class="btn btn-primary" id="crear_categoria_formulario_mandar">Guardar Categoría</button>
            </div>
        </div>
    </div>
</div>
