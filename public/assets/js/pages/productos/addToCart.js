"use strict";

const InitAddCart = function () {

    let submitButton, productInput, quantityInput, cartcounter;

    const initVariables = function () {
        submitButton = document.querySelector("#button-cart");
        productInput = document.querySelector("#product-id");
        quantityInput = document.querySelector("#quantity");
        cartcounter = document.querySelector("#cart-counter")

        initSubmit();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
                let dataId = submitButton.dataset.id;
                if(dataId == -1){
                    Swal.fire({
                        text: 'Porfavor, inicia sesión para agregar productos',
                        icon: 'warning',
                        buttonsStyling: true,
                        showCancelButton: true,
                        confirmButtonText: 'Iniciar Sesión',
                        cancelButtonText: 'Ok',
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = "/login";
                        }
                    });
                } else {
                    const dataToSend = {
                        producto_id: productInput.value,
                        quantity: quantityInput.value,
                        user_id: dataId
                    };
                    
                    createItem(dataToSend);
                }
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/carts',
            data: data,
            method: 'POST',
            success: function(dataReceived) {
                showToast("Producto agregado", 'success');
                cartcounter.textContent = dataReceived.data;
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
    InitAddCart.init();
});
