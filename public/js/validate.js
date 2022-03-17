$(document).ready(function () {
    $('#form').validate({
        rules: {
            name: {
                required: true,
                validName: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                isLetterInPassword: true,
                isDigitInPassword: true
            }
        },
        messages: {
            name: {
                required: 'Wpisz imię',
            },
            email: {
                required: 'Wpisz email',
                email: 'Wpisz poprawny email'
            },
            password: {
                required: 'Wpisz hasło',
                minlength: 'Hasło musi zawierać przynajmniej 8 znaków'
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

$.validator.addMethod('isLetterInPassword',
    function (value, element, param) {
        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
        }
        return true;
    },
    'Hasło powinno zawierać przynajmniej jedną literę'
)

$.validator.addMethod('isDigitInPassword',
    function (value, element, param) {
        if (value != '') {
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }
        return true;
    },
    'Hasło powinno zawierać przynajmniej jedną cyfrę'
)