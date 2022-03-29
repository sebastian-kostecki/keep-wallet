const iconButton = document.querySelector('#chosen-icon-button');
const chosenIcon = document.querySelector('.chosen-icon-input');
const hiddenInputs = document.querySelectorAll('.chosen-icon-input-value');

const myModal = new bootstrap.Modal(document.getElementById('choiceIncomeIcon'), {
    keyboard: false
})

iconButton.addEventListener('click', function () {
    for (let hiddenInput of hiddenInputs) {
        if (chosenIcon.value != NULL) {
            hiddenInput.value = chosenIcon.value;
            console.log(hiddenInput.value);
            myModal.toggle();
        }
    }
})