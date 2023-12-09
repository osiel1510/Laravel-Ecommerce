"use strict";

const InitUsers = function () {

    let submitButton, cancelButton, form, modal, datatable, user, openButton;

    const initDataTable = function () {
        datatable = $('#tabla-user').DataTable({
            responsive: true,
            dom: 'rtp',
            ajax: {
                url: '/users/datatable'
            },
            columnDefs: [
                {
                    targets: 0,
                    data: 'name'
                },
                {
                    targets: 1,
                    data: 'email'
                },
                {
                    targets: 2,
                    data: 'role'
                },
                {
                    targets: 3,
                    data: 'created_at',
                    className: 'text-end text-nowrap',
                    render: function (__data, __type, row) {
                        return `
                                <a href="javascript:;" class="edit-item" data-id="${row.id}">
                                    <button type="button" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                </a>
                                <a href="javascript:;" class="delete-item" data-id="${row.id}">
                                    <button type="button" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </a>`;
                    }
                },
            ]
        });
        
        $('#busqueda').keyup(function() {
            datatable.search($(this).val()).draw();
        });
    }

    const initVariables = function () {
        modal = new bootstrap.Modal(document.querySelector("#crear_user_modal"));
        form = document.querySelector("#crear_user_formulario");
        submitButton = document.querySelector("#crear_user_formulario_mandar");
        cancelButton = document.querySelector("#crear_user_formulario_cancelar");
        openButton = document.querySelector("#crear_user_modal_open");

        initSubmit();
        initOpenModal();
        initCancel();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            const data = {
                role: form.querySelector('[name="role"]').value,
                name: form.querySelector('[name="name"]').value,
                email: form.querySelector('[name="email"]').value,
                password: form.querySelector('[name="password"]').value,
                password_confirmation: form.querySelector('[name="password_confirmation"]').value,
            }

            if (form.querySelector('[name="id"]').value != '') {
                data['id'] = form.querySelector('[name="id"]').value;
                updateItem(data)
            } else {
                createItem(data);
            }
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/users',
            data: data,
            method: 'POST',
            success: function(__data) {
                datatable.ajax.reload()
                modal.hide();
                resetForm();
                user = null;
                showToast("Usuario registrado con éxito", 'success');
            },
            error: function (data) {
                let errors = '';
                for (const [key, value] of Object.entries(data.responseJSON.message)) {
                    errors += `${value}`;
                }
                
                console.log(errors);
                showToast(errors, 'success');
            },
            complete(__data) {
            }
        });
    }

    const initOpenModal = function(){
        openButton.addEventListener("click", (function(e) {
            e.preventDefault();
            resetForm();
            modal.show();
        }));
    }

    const initCancel = function () {
        cancelButton.addEventListener("click", (function(e) {
            e.preventDefault();
            modal.hide();
            user = null;
            resetForm();
        }));
    }

    const resetForm = function () {
        form.querySelector('[name="name"]').value = '';
        form.querySelector('[name="email"]').value = '';
        form.querySelector('[name="password"]').value = '';
        form.querySelector('[name="password_confirmation"]').value = '';
    }

    const initDelete = function () {
        $(document).on('click', '.delete-item', function () {
            const data = $(this).data();
            Swal.fire({
                text: '¿Seguro que deseas eliminar este usuario?',
                icon: 'warning',
                buttonsStyling: true,
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
            }).then(result => {
                if (result.isConfirmed) {
                    deleteItem(data.id)
                }
            });
        });
    }

    const deleteItem = function (id) {
        $.ajax({
            url: `/users/${id}`,
            data: {},
            method: 'DELETE',
            success: function(__data) {
                datatable.ajax.reload();
                showToast("Usuario eliminado con éxito", 'success');
            },
            error: function (data) {
                let errors = '';
                for (const [key, value] of Object.entries(data.responseJSON.message)) {
                    errors += `${value}`;
                }

                showToast(errors, 'success');
            },
            complete(data) {

            }
        });
    }

    const initEdit = function () {
        $(document).on('click', '.edit-item', function () {
            const data = $(this).data();
            getItem(data.id);
        });
    }

    const getItem = function (id) {
        $.ajax({
            url: `/users/${id}`,
            data: {},
            method: 'GET',
            success: function(res) {
                user = res.data;
                form.querySelector('[name="id"]').value = user.id;
                form.querySelector('[name="name"]').value = user.name;
                form.querySelector('[name="email"]').value = user.email;
                form.querySelector('[name="role"]').value = user.role;
                modal.show();
            },  
            error: function (data) {
                let errors = '';
                for (const [key, value] of Object.entries(data.responseJSON.message)) {
                    errors += `${value}`;
                }

                showToast(errors, 'success');
            },
            complete(__data) {

            }
        });
    }

    const updateItem = function (data) {
        $.ajax({
            url: `/users/${data.id}`,
            data: data,
            method: 'PUT',
            success: function(__data) {
                datatable.ajax.reload();
                modal.hide();
                resetForm();
                user = null;
                showToast("Usuario actualizado con éxito", 'success');
            },
            error: function (data) {
                let errors = '';
                for (const [key, value] of Object.entries(data.responseJSON.message)) {
                    errors += `${value}`;
                }

                console.log(errors);
                showToast(errors, 'error');
            },
            complete(__data) {
            }
        });
    }

    // Public methods
    return {
        init: function () {

            jQuery.ajaxSetup({
                headers: { 'x-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            });
        
            initVariables();
            initOpenModal();
            initDataTable();
            initDelete();
            initEdit();
        }
    }
}();

document.addEventListener("DOMContentLoaded", function() {
    InitUsers.init();
});
