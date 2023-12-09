<!-- Modal para crear un nuevo usuario -->
<div class="modal fade" id="crear_user_modal" tabindex="-1" role="dialog" aria-labelledby="crear_user_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crear_user_formulario">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label>Nombre del usuario</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <input type="text" class="form-control" name="role">
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirmar Contraseña</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="crear_user_formulario_cancelar">Cerrar</button>
                <button type="button" class="btn btn-primary" id="crear_user_formulario_mandar">Guardar Usuario</button>
            </div>
        </div>
    </div>
</div>
