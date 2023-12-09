"use strict";

const InitMarcas = function () {

    let submitButton, cancelButton, form, modal, datatable, marca, openButton;

    const initDataTable = function () {
        datatable = $('#tabla-marca').DataTable({
            responsive: true,
            dom: 'rtp',
            ajax: {
                url: '/marcas/datatable'
            },
            columnDefs: [
                {
                    targets: 0,
                    data: 'name'
                },
                {
                    targets: 1,
                    data: 'image',
                    render: function (data, type, row) {
                        var imagePath = '/storage/marcas/' + data; 
                        return `<img src="${imagePath}" class="img-fluid" style="max-width: 100px; height: auto;">`;
                    }
                },
                {
                    targets: 2,
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
    }

    const initVariables = function () {
        modal = new bootstrap.Modal(document.querySelector("#crear_marca_modal"));
        form = document.querySelector("#crear_marca_formulario");
        submitButton = document.querySelector("#crear_marca_formulario_mandar");
        cancelButton = document.querySelector("#crear_marca_formulario_cancelar");
        openButton = document.querySelector("#crear_marca_modal_open");

        initSubmit();
        initOpenModal();
        initCancel();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
    
            let formData = new FormData(form);

            if (form.querySelector('[name="id"]').value != '') {
                formData.append('id', form.querySelector('[name="id"]').value);
                updateItem(formData);
            } else {
                createItem(formData);
            }
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/marcas',
            data: data,
            processData: false, // No procesar los datos
            contentType: false, // No establecer el tipo de contenido
            method: 'POST',
            success: function(__data) {
                datatable.ajax.reload()
                modal.hide();
                resetForm();
                marca = null;
                showToast("Marca registrado con éxito", 'success');
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
            marca = null;
            resetForm();
        }));
    }

    const resetForm = function () {
        form.querySelector('[name="name"]').value = '';
    }

    const initDelete = function () {
        $(document).on('click', '.delete-item', function () {
            const data = $(this).data();
            Swal.fire({
                text: '¿Seguro que deseas eliminar este marca?',
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
            url: `/marcas/${id}`,
            data: {},
            method: 'DELETE',
            success: function(__data) {
                datatable.ajax.reload();
                showToast("Marca eliminado con éxito", 'success');
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
            url: `/marcas/${id}`,
            data: {},
            method: 'GET',
            success: function(res) {
                marca = res.data;
                form.querySelector('[name="id"]').value = marca.id;
                form.querySelector('[name="name"]').value = marca.name;
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
        let formData = data;
        if (!(data instanceof FormData)) {
            formData = new FormData();
            for (let key in data) {
                formData.append(key, data[key]);
            }
        }

        formData.append('_method', 'PUT');
    
        $.ajax({
            url: `/marcas/${formData.get('id')}`,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            success: function(__data) {
                datatable.ajax.reload();
                modal.hide();
                resetForm();
                marca = null;
                showToast("Marca actualizado con éxito", 'success');
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
    InitMarcas.init();
});
