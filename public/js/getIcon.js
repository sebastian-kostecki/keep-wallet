const buttonChosenIconInModal = document.querySelector('#button-chosen-icon-in-modal');
const iconCheckButtons = document.querySelectorAll('.button-chosen-icon');

const myModal = new bootstrap.Modal(document.getElementById('choiceIncomeIcon'), {
    keyboard: false
})

for (let iconCheckButton of iconCheckButtons) {
    iconCheckButton.addEventListener('click', function () {
        buttonChosenIconInModal.addEventListener('click', function () {
            let chosenIcon = document.querySelector('.selected-icon-in-modal:checked');
            iconCheckButton.innerHTML = '<i class="' + chosenIcon.value + '">';
            iconCheckButton.nextElementSibling.value = chosenIcon.value;

            const error = document.querySelector('#icon-error');
            if (error.style.display = 'inline-block') {
                error.style.display = 'none';
            }

            myModal.toggle();
        })
    })
}