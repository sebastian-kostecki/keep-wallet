const forms = document.querySelectorAll('.single-form');

for (let form of forms) {
    $(document).ready(function () {
        $(form).validate({
            rules: {
                name: {
                    required: true,
                    validName: true,
                    minlength: 3,
                    maxlength: 50,
                    remote: '/account/validate-name'
                },
                email: {
                    required: true,
                    email: true,
                    remote: '/account/validate-email'
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
                    minlength: 'Imię powinno zawierać co najmniej 3 znaki',
                    maxlength: 'Imię może zawierać maksymalnie 50 znaków',
                    remote: 'Podane imię jest zajęte'
                },
                email: {
                    required: 'Wpisz email',
                    email: 'Wpisz poprawny email',
                    remote: 'Podany email jest zajęty'
                },
                password: {
                    required: 'Wpisz hasło',
                    minlength: 'Hasło musi zawierać przynajmniej 8 znaków'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "name")
                    error.insertAfter("#submit-change-name");
                else {
                    error.insertAfter(element);
                }

            },
        });
    });
}



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