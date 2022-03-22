$(document).ready(function () {
    $('.budget-form').validate({
        rules: {
            amount: {
                required: true
            },
            date: {
                required: true
            },
            incomeCategory: {
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
    });
});