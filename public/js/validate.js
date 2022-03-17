$(document).ready(function () {
    $('#form').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
            },
            firstPassword: {
                required: true,
                minlength: 6,
            }
        },
    });
});