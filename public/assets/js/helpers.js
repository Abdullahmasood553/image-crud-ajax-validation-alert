function showCustomSuccess(text) {
    Swal.fire(
        'Success!',
        text,
        'success'
    )
}


function showCustomError(text) {
    Swal.fire(
        {
            icon: 'error',
            title: 'Oops...',
            text:text
        })
}