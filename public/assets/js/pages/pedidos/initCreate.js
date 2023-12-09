"use strict";

const InitProductos = function () {

    let submitButton, form;    

    const initVariables = function () {
        form = document.querySelector("#crear_producto_formulario");
        submitButton = document.querySelector("#crear_producto_formulario_mandar");
        initSubmit();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            
            let formData = new FormData(form);
            createItem(formData);
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/pedidos',
            data: data,
            processData: false, // No procesar los datos
            contentType: false, // No establecer el tipo de contenido
            method: 'POST',
            success: function(dataReceived) {
                $('#title-page').text("");
                $('#main-content-div').html(`
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <h2>¡Gracias por tu pedido! Tu pedido es el #${dataReceived.data}</h2>
                        <h2>Te enviaremos un correo para seguir con tu pedido</h2>
                    </div>
                `);
                document.querySelector("#cart-counter").textContent = "0";
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
    
    // Public methods
    return {
        init: function () {

            jQuery.ajaxSetup({
                headers: { 'x-CSRF-Token': $('meta[name="csrf-token"]').attr('content') }
            });
        
            initVariables();
        }
    }
}();

document.addEventListener("DOMContentLoaded", function() {
    InitProductos.init();
});
