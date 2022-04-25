$(document).ready(function () {
    $('.budget-form').validate({
        rules: {
            amount: {
                required: true,
                validAmount: true,
                step: false
            },
            date: {
                required: true
            },
            paymentMethod: {
                required: true
            },
            category: {
                required: true
            },
            comment: {
                maxlength: 100
            }
        },
        messages: {
            amount: {
                required: 'Wpisz kwotę',
                number: 'Kwota jest nieprawidłowa',
                step: 'Kwota jest nieprawidłowa'
            },
            date: {
                required: 'Wybierz datę'
            },
            paymentMethod: {
                required: 'Wybierz sposób płatności'
            },
            category: {
                required: 'Wybierz kategorię wydatku'
            },
            comment: {
                maxlength: 'Komentarz może zawierać maksymalnie 100 znaków'
            }
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "category")
                error.insertAfter("#comment");
            else if (element.attr("name") == "paymentMethod") {
                error.insertAfter("#paymentMethods");
            }
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