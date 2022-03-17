$(document).ready(function () {
    $('#form').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
    });
});