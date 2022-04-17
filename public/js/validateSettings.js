// const forms = document.querySelectorAll('single-form');

// const submitFormsButtons = document.querySelectorAll('button[type=submit]');
// const confirmModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
//     keyboard: false
// })
// const confirmButton = document.querySelector('#confirm-changes-button');

// for (let form of forms) {
//     $(document).ready(function () {
//         $(form).validate({
//             ignore: [],
//             submitHandler: function (f, event) {
//                 confirmModal.toggle();
//                 confirmButton.addEventListener('click', function () {
//                     confirmModal.toggle();
//                     f.submit();
//                 })
//             },
//             rules: {
//                 name: {
//                     required: true,
//                     validName: true,
//                     minlength: 3,
//                     maxlength: 50,
//                     remote: '/account/validate-name'
//                 },
//                 password: {
//                     required: true,
//                     minlength: 8,
//                     isLetterInPassword: true,
//                     isDigitInPassword: true
//                 },
//                 icon: {
//                     required: true
//                 },
//                 nameCategory: {
//                     required: true
//                 },
//                 previousCategory: {
//                     required: true
//                 },
//                 "categoriesToDelete[]": {
//                     required: true
//                 }
//             },
//             messages: {
//                 name: {
//                     required: 'Wpisz imię',
//                     minlength: 'Imię powinno zawierać co najmniej 3 znaki',
//                     maxlength: 'Imię może zawierać maksymalnie 50 znaków',
//                     remote: 'Podane imię jest zajęte'
//                 },
//                 password: {
//                     required: 'Wpisz hasło',
//                     minlength: 'Hasło musi zawierać przynajmniej 8 znaków'
//                 },
//                 icon: {
//                     required: "Wybierz ikonę"
//                 },
//                 nameCategory: {
//                     required: 'Wpisz nazwę kategorii'
//                 },
//                 previousCategory: {
//                     required: 'Wybierz kategorię do zmiany'
//                 },
//                 "categoriesToDelete[]": {
//                     required: 'Wybierz kategorię do usunięcia'
//                 }
//             },
//             errorPlacement: function (error, element) {
//                 if (element.attr("name") == "name")
//                     error.insertAfter("#submit-change-name");
//                 else if (element.attr("name") == "password") {
//                     error.insertAfter("#submit-change-password");
//                 }
//                 else if ((element.attr("name") == "nameCategory") || (element.attr("name") == "icon")) {
//                     error.insertAfter(element.siblings().last());
//                 }
//                 else if ((element.attr("name") == "oldCategory") || (element.attr("name") == "categoriesToDelete[]") || (element.attr("name") == "previousCategory")) {
//                     error.insertAfter(element.parent().nextAll().last());
//                 }
//                 else {
//                     error.insertAfter(element);
//                 }
//             },
//         });
//     });
// }

$.validator.addMethod('validName',
    function (value) {
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

//nowy kod

$(document).ready(function () {
    $('#change-user-data').validate({
        // submitHandler: function (f, event) {
        //     f.addEventListener('submit', function (e) {
        //         const name = $(this).find('[name="name"]')[0];
        //         const password = $(this).find('[name="password"]')[0];
        //         if ((name.value === '') && (password.value === '')) {
        //             e.preventDefault();
        //         } else {
        //             f.submit();
        //         }
        //     })
        // },
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
            }
        },
        messages: {
            name: {
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