const forms = document.querySelectorAll('.single-form');

for (let form of forms) {
    $(document).ready(function () {
        $(form).validate({
            rules: {
                name: {
                    validName: true,
                    minlength: 3,
                    maxlength: 50,
                    remote: '/account/validate-name'
                },
                password: {
                    minlength: 8,
                    isLetterInPassword: true,
                    isDigitInPassword: true
                },
                icon: {
                    required: true,
                    isIconSelect: true
                },
                nameCategory: {
                    required: true
                },
                oldCategory: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'Wpisz imię',
                    minlength: 'Imię powinno zawierać co najmniej 3 znaki',
                    maxlength: 'Imię może zawierać maksymalnie 50 znaków',
                    remote: 'Podane imię jest zajęte'
                },
                password: {
                    required: 'Wpisz hasło',
                    minlength: 'Hasło musi zawierać przynajmniej 8 znaków'
                },
                nameCategory: {
                    required: 'Wpisz nazwę kategorii'
                },
                oldCategory: {
                    required: 'Wybierz kategorię'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "name")
                    error.insertAfter("#submit-change-name");
                else if (element.attr("name") == "password") {
                    error.insertAfter("#submit-change-password");
                }
                else if (element.attr("name") == "nameCategory") {
                    error.insertAfter(element.next());
                }
                else if (element.attr("name") == "oldCategory") {
                    error.insertAfter(element.parent().nextAll().last());
                }
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

$.validator.addMethod('isIconSelect',
    function (value, element, param) {
        if (value == "") {
            return false;
        }
        return true;
    },
    'Wybierz ikonę'
)