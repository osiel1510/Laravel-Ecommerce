<!-- Modal para crear un nuevo usuario -->
<div class="modal fade" id="crear_producto_modal" tabindex="-1" role="dialog" aria-labelledby="crear_producto_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crear_producto_formulario" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    
                    <div class="form-group">
                        <label>Nombre de producto</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Precio</label>
                        <input type="text" class="form-control" name="price">
                    </div>

                    <div class="form-group">
                        <label>Stock</label>
                        <input type="text" class="form-control" name="stock">
                    </div>

                    <div class="form-group">
                        <label>Descuento</label>
                        <input type="text" class="form-control" name="discount">
                    </div>

                    <div class="form-group">
                        <label>Categoría ID</label>
                        <select class="form-control" name="categoria_id">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Destacado</label>
                        <select class="form-control" name="destacado">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="crear_producto_formulario_cancelar">Cerrar</button>
                <button type="button" class="btn btn-primary" id="crear_producto_formulario_mandar">Guardar Categoría</button>
            </div>
        </div>
    </div>
</div>
