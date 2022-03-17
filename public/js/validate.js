$(document).ready(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true,
                validName: true
            },
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

$.validator.addMethod('validName',
    function (value, element, param) {
        if (value != '') {
            if (value.match(/.*[$&+,:;=?[\]@#|{}'<>.^*()%!-/]+.*/i)) {
                return false;
            }
        }
        return true;
    },
    'Hasło nie może zawierać znaków specjalnych'
)