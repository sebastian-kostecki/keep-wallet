$(document).ready(function () {
    $('.budget-form').validate({
        rules: {
            amount: {
                required: true,
                validAmount: true
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
        errorPlacement: function (error, element) {
            if (element.attr("name") == "incomeCategory")
                error.insertAfter("#comment");
            else {
                error.insertAfter(element);
            }

        },
    });
});

$.validator.addMethod('validAmount',
    function (value, element, param) {
        value *= 1000;
        if (value % 10 == 0 && value > 0) {
            return true;
        }
        return false;
    },
    'Kwota jest nieprawidłowa'
)