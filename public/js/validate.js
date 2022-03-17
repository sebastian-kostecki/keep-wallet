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
        messages: {
            name: {
                required: 'Wpisz imię',
            },
            email: {
                required: 'Wpisz email',
                email: 'Wpisz poprawny email'
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
    'Imię nie może zawierać znaków specjalnych'
)