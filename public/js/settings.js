const modalAddNewElement = new bootstrap.Modal(document.getElementById('add-new-element'), {
    keyboard: false
})
const buttonsAddNewElement = document.querySelectorAll('.button-add-element');
const form = document.querySelector('#add-new-element form');

for (let buttonAddNewElement of buttonsAddNewElement) {
    buttonAddNewElement.addEventListener('click', function () {
        modalAddNewElement.toggle();
        form.action = '/settings/' + buttonAddNewElement.id;
    })
}

const buttonAddNewElementInModal = document.querySelector('#button-add-new-element-in-modal');
buttonAddNewElementInModal.addEventListener('click', function () {
    form.submit();
})