"use strict";

const InitUsers = function () {

    let submitButton, form, user;

    const initVariables = function () {
        form = document.querySelector("#crear_user_formulario");
        submitButton = document.querySelector("#crear_user_formulario_mandar");

        initSubmit();
    }

    const initSubmit = function () {
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            const data = {
                name: form.querySelector('[name="name"]').value,
                email: form.querySelector('[name="email"]').value,
                password: form.querySelector('[name="password"]').value,
                password_confirmation: form.querySelector('[name="password_confirmation"]').value,
            }

            createItem(data);
        })
    }

    const createItem = function (data) {
        $.ajax({
            url: '/users/client',
            data: data,
            method: 'POST',
            success: function(__data) {
                resetForm();
                showToast("¡Registrado con éxito!", 'success');
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

    const resetForm = function () {
        form.querySelector('[name="name"]').value = '';
        form.querySelector('[name="email"]').value = '';
        form.querySelector('[name="password"]').value = '';
        form.querySelector('[name="password_confirmation"]').value = '';
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
    InitUsers.init();
});
