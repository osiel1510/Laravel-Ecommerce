"use strict";

const InitProductos = function () {

    let submitButton, cancelButton, form, modal, datatable, producto, openButton;

    const initDataTable = function () {
        datatable = $('#tabla-producto').DataTable({
            responsive: true,
            dom: 'rtp',
            ajax: {
                url: '/productos/datatable'
            },
            pageLength: 2,
            columnDefs: [
                {
                    targets: 0,
                    data: 'name',
                },
                {
                    targets: 1,
                    data: 'image',
                    render: function (data, type, row) {
                        var imagePath = '/storage/productos/' + data; 
                        return `<img src="${imagePath}" class="img-fluid" style="max-width: 100px; height: auto;">`;
                    }
                },
                {
                    targets: 2,
                    data: 'stock',
                },
                {
                    targets: 3,
                    data: 'categoria.name',
                },
                {
                    targets: 4,
                    data: 'description',
                    render: function (data, type, row) {
                        if (type === 'display' && data.length > 50) { // Cambia 50 por la longitud deseada
                            return data.substr(0, 50) + '...'; // Cambia 50 por la longitud deseada
                        } else {
                            return data;
                        }
                    }
                },
                {
                    targets: 5,
                    data: 'price',
                },
                {
                    targets: 6,
                    data: 'discount',
                }
                ,
                {
                    targets: 7,
                    data: 'destacado',
                    render: function (data, type, row) {
                        if (data == '0') { 
                            return 'No';
                        } else {
                            return 'Si';
                        }
                    }
                },
                {
                    targets: 8,
                    data: 'created_at',
                    className: 'text-end text-nowrap',  
                    render: function (__data, __type, row) {
                        return `
                                <a href="javascript:;" class="edit-item" data-id="${row.id}">
                                    <button type="button" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                </a>
                                <a href="javascript:;" class="edit-images" data-id="${row.id}">
                                <button type="button" class="btn btn-warning">
                                    <i class="bi bi-card-image"></i> Editar
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
        modal = new bootstrap.Modal(document.querySelector("#crear_producto_modal"));
        form = document.querySelector("#crear_producto_formulario");
        submitButton = document.querySelector("#crear_producto_formulario_mandar");
        cancelButton = document.querySelector("#crear_producto_formulario_cancelar");
        openButton = document.querySelector("#crear_producto_modal_open");

        fillCategories();
        initSubmit();
        initOpenModal();
        initCancel();
    }

    const fillCategories = function () {
        $.ajax({
            url: '/categorias/all',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('select[name="categoria_id"]');
                select.empty();
    
                $.each(data, function(key, value) {
                    select.append($('<option></option>')
                        .attr('value', value.id) 
                        .text(value.name)
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener las categorías:', error);
            }
        });
    
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
            url: '/productos',
            data: data,
            processData: false, // No procesar los datos
            contentType: false, // No establecer el tipo de contenido
            method: 'POST',
            success: function(__data) {
                datatable.ajax.reload()
                modal.hide();
                resetForm();
                producto = null;
                showToast("Producto registrado con éxito", 'success');
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
            producto = null;
            resetForm();
        }));
    }

    const resetForm = function () {
        form.querySelector('[name="id"]').value = '';
        form.querySelector('[name="name"]').value = '';
        form.querySelector('[name="stock"]').value = '';
        form.querySelector('[name="discount"]').value = '';
        form.querySelector('[name="price"]').value = '';
        form.querySelector('[name="description"]').value = '';
        form.querySelector('[name="destacado"]').value = '0';
    }

    const initDelete = function () {
        $(document).on('click', '.delete-item', function () {
            const data = $(this).data();
            Swal.fire({
                text: '¿Seguro que deseas eliminar este producto?',
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
            url: `/productos/${id}`,
            data: {},
            method: 'DELETE',
            success: function(__data) {
                datatable.ajax.reload();
                showToast("Producto eliminado con éxito", 'success');
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
            url: `/productos/${id}`,
            data: {},
            method: 'GET',
            success: function(res) {
                producto = res.data;
                console.log(producto);
                form.querySelector('[name="id"]').value = producto.id;
                form.querySelector('[name="stock"]').value = producto.stock;
                form.querySelector('[name="discount"]').value = producto.discount;
                form.querySelector('[name="description"]').value = producto.description;
                form.querySelector('[name="price"]').value = producto.price;
                form.querySelector('[name="name"]').value = producto.name;
                form.querySelector('[name="categoria_id"]').value = producto.categoria.id;
                form.querySelector('[name="destacado"]').value = producto.destacado;
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
            url: `/productos/${formData.get('id')}`,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            success: function(__data) {
                datatable.ajax.reload();
                modal.hide();
                resetForm();
                producto = null;
                showToast("Producto actualizado con éxito", 'success');
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
    InitProductos.init();
});
