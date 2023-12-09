"use strict";

const InitProductos = function () {

    let datatable;

    const initDataTable = function () {
        datatable = $('#tabla-producto').DataTable({
            responsive: true,
            dom: 'rtp',
            ajax: {
                url: '/pedidos/datatable'
            },
            order: [
                [6, 'desc'], // Ordenar por la columna de estado (status) de manera ascendente
                [5, 'desc']  // Luego ordenar por la columna de fecha (created_at) de manera descendente
            ],
            columnDefs: [
                {
                    targets: 0,
                    data: 'id'
                },
                {
                    targets: 1,
                    data: 'nombre'
                },
                {
                    targets: 2,
                    data: 'correo',
                },
                {
                    targets: 3,
                    data: null,
                    defaultContent: '',
                    render: function(data, type, row) {
                        var total = 0;
                        if (type === 'display' || type === 'filter') {
                            row.productos.forEach(function(producto) {
                                total += producto.precio * producto.cantidad;
                            });
                        }
                        return '$' + total.toFixed(2).toString();
                    }
                },
                
                {
                    targets: 4,
                    data: 'municipio',
                },
                {
                    targets: 5,
                    data: 'created_at',
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            var date = new Date(data);
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            var formattedDate = day + '/' + month + '/' + year;
                            return formattedDate;
                        }
                        return data;
                    }
                },                
                {
                    targets: 6,
                    data: 'status',
                    render: function(data, type, row) {
                        var statusClass = '';
                        var statusText = data.toUpperCase(); // Convierte el estado a mayúsculas
                
                        switch (data) {
                            case 'completado':
                                statusClass = 'text-success'; // Clase de Bootstrap para verde
                                break;
                            case 'pendiente':
                                statusClass = 'text-warning'; // Clase de Bootstrap para amarillo
                                break;
                            case 'cancelado':
                                statusClass = 'text-danger'; // Clase de Bootstrap para rojo
                                break;
                            default:
                                break;
                        }
                
                        // Agregamos la clase 'font-weight-bold' para negrita
                        return '<span class="' + statusClass + ' font-weight-bold">' + statusText + '</span>';
                    }
                },                           
                {
                    targets: 7,
                    data: 'created_at',
                    className: 'text-end text-nowrap',  
                    render: function (__data, __type, row) {
                        return `<a href="javascript:;" class="edit-item" data-id="${row.id}">
                                    <button type="button" class="btn btn-warning">
                                        <i class="bi bi-eye-fill"></i>
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

    const initView = function () {
        $(document).on('click', '.edit-item', function () {
            const data = $(this).data();
            viewItem(data.id);
        });
    }

    const viewItem = function (data) {
        window.location.href = `/pedidos/view/${data}`;
    }
    
    // Public methods
    return {
        init: function () {

            jQuery.ajaxSetup({
                headers: { 'x-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            });
        
            initDataTable();
            initView();
        }
    }
}();

document.addEventListener("DOMContentLoaded", function() {
    InitProductos.init();
});
