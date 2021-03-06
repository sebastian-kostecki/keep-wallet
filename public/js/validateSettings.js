$(document).ready(function () {
    $('#change-user-data').validate({
        rules: {
            name: {
                isSpecialLetter: true,
                minlength: 3,
                maxlength: 50,
                remote: '/account/validate-name'
            },
            password: {
                minlength: 8,
                isLetterInPassword: true,
                isDigitInPassword: true
            }
        },
        messages: {
            name: {
                isSpecialLetter: 'Imię nie może zawierać znaków specjalnych',
                minlength: 'Imię powinno zawierać co najmniej 3 znaki',
                maxlength: 'Imię może zawierać maksymalnie 50 znaków',
                remote: 'Podane imię jest zajęte'
            },
            password: {
                minlength: 'Hasło musi zawierać przynajmniej 8 znaków'
            }
        },
    });
});

const formChangingUserData = document.querySelector('#change-user-data');
formChangingUserData.addEventListener('submit', function (e) {
    const name = $(this).find('[name="name"]')[0];
    const password = $(this).find('[name="password"]')[0];
    if ((name.value === '') && (password.value === '')) {
        e.preventDefault();
    } else {
        $(this).submit();
    }
})


$('#form-add-change-category').validate({
    ignore: "",
    rules: {
        icon: "required",
        nameCategory: {
            required: true,
            isSpecialLetter: true
        },
        limitAmount: {
            validAmount: true,
            step: false
        }
    },
    messages: {
        icon: {
            required: "Wybierz ikonę"
        },
        nameCategory: {
            required: 'Wpisz nazwę kategorii',
            isSpecialLetter: 'Nazwa kategorii nie może zawierać znaków specjalnych'
        },
        limitAmount: {
            number: 'Kwota jest nieprawidłowa',
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "icon") {
            error.insertAfter(element.next());
        }
        else {
            error.insertAfter(element);
        }
    }
});


$.validator.addMethod('isSpecialLetter',
    function (value) {
        if (value != '') {
            if (value.match(/.*[$&+,:;=?[\]@#|{}'<>.^*()%!-/]+.*/i)) {
                return false;
            }
        }
        return true;
    },
)

$.validator.addMethod('isLetterInPassword',
    function (value) {
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
    function (value) {
        if (value != '') {
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }
        return true;
    },
    'Hasło powinno zawierać przynajmniej jedną cyfrę'
)

$.validator.addMethod('validAmount',
    function (value) {
        value *= 1000;
        if (value % 10 == 0 && value > 0) {
            return true;
        }
        return false;
    },
    'Kwota jest nieprawidłowa'
)