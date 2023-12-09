"use strict";

const InitProductos = function () {

    let submitButton, datatable, quantityInputs, cartcounter;

    const initDataTable = function () {
        datatable = $('#tabla-carrito').DataTable({
            responsive: true,
            dom: 'rt',
            ajax: {
                url: '/carts/actualCart'
            },
            columnDefs: [
                {
                    targets: 0,
                    data: 'producto.name'
                },
                {
                    targets: 1,
                    data: 'producto.image',
                    render: function (data, type, row) {
                        var imagePath = '/storage/productos/' + data; 
                        return `<img src="${imagePath}" class="img-fluid" style="max-width: 100px; height: auto;">`;
                    }
                },
                {
                    targets: 2,
                    data: 'quantity',
                    render: function (data, type, row) {
                        return `<input type="number" value="${row.quantity}" min=1
                            data-id="${row.producto_id}" class="form-control form-control-sm quantity-input">`;
                    }
                },
                {
                    targets: 3,
                    data: 'producto.price',
                    render: function (data, type, row) {
                        if(row.producto.discount != 0){
                            return '$' + row.producto.discount;
                        } else {
                            return '$' + data;
                        }
                    }
                },
                {
                    targets: 4,
                    data: 'producto.price',
                    render: function (data, type, row) {
                        if (row.producto.discount != 0) {
                            return '$' + row.producto.discount * row.quantity;
                        } else {
                            return '$' + row.producto.price * row.quantity;
                        }
                    }
                },
                {
                    targets: 5,
                    data: 'created_at',
                    className: 'text-end text-nowrap',  
                    render: function (__data, __type, row) {
                        return `
                                <a href="javascript:;" class="delete-item" data-id="${row.id}">
                                    <button type="button" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> 
                                    </button>
                                </a>`;
                    }
                },
            ]
        });
        
        datatable.on('draw.dt', function() {
            initVariables();

            let totalQuantity = 0;

            datatable.rows().every(function () {
                const cellNode = this.cell(this.index(), 4).nodes().to$(); // Obtén el nodo de la celda
                const cellRenderedValue = cellNode[0].textContent;
                totalQuantity += parseFloat(cellRenderedValue.replace('$', '').replace(',', '')); // Elimina el símbolo '$' y las comas y convierte a número
                
            });
            
            document.getElementById('total').textContent = 'Total: $' + totalQuantity;
                    
        });
    }    

    const initVariables = function () {
        submitButton = document.querySelector("#button-pagar");
        quantityInputs = document.querySelectorAll(".quantity-input");
        cartcounter = document.querySelector("#cart-counter");
        initSubmit();
        initQuantityInputs();
        initDelete();
    }

    const initQuantityInputs = function () {
        quantityInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var dataId = input.getAttribute('data-id');
                var nuevoValor = input.value;
                let dataToSend = {};
                dataToSend.id = dataId;
                dataToSend.value = nuevoValor;

                $.ajax({
                    url: '/carts/updateItem',
                    data: dataToSend,
                    method: 'POST',
                    success: function(dataReceived) {
                        datatable.ajax.reload()
                        cartcounter.textContent = dataReceived.data;
                    },
                    error: function (data) {
                        let errors = '';
                        for (const [key, value] of Object.entries(data.responseJSON.message)) {
                            errors += `${value}`;
                        }
                        datatable.ajax.reload()
                        showToast(errors, 'success');
                    },
                    complete(__data) {
                    }
                });

            });
        });        
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function() {
            window.location.href = "/pedidos/create";
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
                
                showToast(errors, 'success');
            },
            complete(__data) {
            }
        });
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
            url: `/carts/${id}`,
            data: {},
            method: 'DELETE',
            success: function(dataReceied) {
                datatable.ajax.reload();
                cartcounter.textContent = dataReceied.data;
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
    
    // Public methods
    return {
        init: function () {

            jQuery.ajaxSetup({
                headers: { 'x-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            });
        
            initDataTable();
            // initDelete();
        }
    }
}();

document.addEventListener("DOMContentLoaded", function() {
    InitProductos.init();
});
