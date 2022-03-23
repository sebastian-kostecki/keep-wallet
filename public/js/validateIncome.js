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
            },
            comment: {
                maxlength: 100
            }
        },
        messages: {
            amount: {
                required: 'Wpisz kwotę',
                number: 'Kwota jest nieprawidłowa'
            },
            date: {
                required: 'Wybierz datę'
            },
            incomeCategory: {
                required: 'Wybierz kategorię przychodu'
            },
            comment: {
                maxlength: 'Komentarz może zawierać maksymalnie 100 znaków'
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