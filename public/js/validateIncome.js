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
            amount: {
                required: 'Wpisz kwotę'
            },
            date: {
                required: 'Wybierz datę'
            },
            incomeCategory: {
                required: 'Wybierz kategorię przychodu'
            }
        },
    });
});