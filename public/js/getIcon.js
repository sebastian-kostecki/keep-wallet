const iconButton = document.querySelector('#chosen-icon-button');
const chosenButton = document.querySelector('.button-chosen-icon');
const chosenIcon = document.querySelectorAll('.chosen-icon-input');
const hiddenInputs = document.querySelectorAll('.chosen-icon-input-value');

const myModal = new bootstrap.Modal(document.getElementById('choiceIncomeIcon'), {
    keyboard: false
})

iconButton.addEventListener('click', function () {
    for (let hiddenInput of hiddenInputs) {
        hiddenInput.value = document.querySelector('.chosen-icon-input:checked').value;
        chosenButton.innerHTML = '<i class="' + hiddenInput.value + ' me-2">';
    }

    console.log(hiddenInputs.value);
    myModal.toggle();
})