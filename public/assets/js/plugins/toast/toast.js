


function showToast(message, type) {
    const toast = Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "right",
    });


    if (type === 'success') {
        toast.showToast({
            className: "custom-toast-success"
        });
    } else if (type === 'error') {
        toast.showToast({
            className: "custom-toast-error"
        });
    }
}