"use strict";

const InitImagenes = function () {

    let submitButton, form, modal, datatable, productoId;

    const initDataTable = function (productoId) {
        const url = `/productos/imagenes/datatable/${productoId}`;
    
        datatable = $('#tabla-imagen').DataTable({
            responsive: true,
            dom: 'rt',
            ajax: {
                url: url,
            },
            columnDefs: [
                {
                    targets: 0,
                    data: 'path',
                    render: function (data, type, row) {
                        var imagePath = '/storage/productos/' + data; 
                        return `<img src="${imagePath}" class="img-fluid" style="max-width: 100px; height: auto;">`;
                    }
                },
                {
                    targets: 1,
                    data: 'path',
                    className: 'text-end text-nowrap',  
                    render: function (__data, __type, row) {
                        return `
                                <a href="javascript:;" class="delete-image" data-id="${row.id}">
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
        modal = new bootstrap.Modal(document.querySelector("#crear_imagen_modal"));
        form = document.querySelector("#crear_imagen_formulario");
        submitButton = document.querySelector("#crear_imagen_formulario_mandar");

        initSubmit();
        initOpenModal();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
    
            let formData = new FormData(form);
            formData.append("id", productoId);
            createItem(formData);
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/productos/imagenes',
            data: data,
            processData: false, // No procesar los datos
            contentType: false, // No establecer el tipo de contenido
            method: 'POST',
            success: function(__data) {
                datatable.ajax.reload()
                showToast("Imagen agregada con éxito", 'success');
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

    const initOpenModal = function () {
        $(document).on('click', '.edit-images', function () {
            const data = $(this).data();
            getItem(data.id);
        });
    }

    const getItem = function (id) {
        if (datatable !== undefined && datatable !== null) {
            datatable.destroy();
        }
        initDataTable(id);
        productoId = id;
        modal.show();
    }

    const initDelete = function () {
        $(document).on('click', '.delete-image', function () {
            const data = $(this).data();
            Swal.fire({
                text: '¿Seguro que deseas eliminar esta Imagen?',
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
            url: `/productos/imagenes/${id}`,
            data: {},
            method: 'DELETE',
            success: function(__data) {
                datatable.ajax.reload();
                showToast("Imagen eliminada con éxito", 'success');
            },
            error: function (data) {
                let errors = '';
                for (const [key, value] of Object.entries(data.responseJSON.message)) {
                    errors += `${value}`;
                }

                showToast(errors, 'success');
            },
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
            initDelete();
        }
    }
}();

document.addEventListener("DOMContentLoaded", function() {
    InitImagenes.init();
});
