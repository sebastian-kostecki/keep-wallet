const modalCreateAndChangeElement = new bootstrap.Modal(document.getElementById('modalCreateChangeCategory'), {
    keyboard: false
})

const buttonsAddingNewElement = document.querySelectorAll('.button-add-element');
const buttonsChangingElement = document.querySelectorAll('.button-change-category');
const buttonsRemovingElement = document.querySelectorAll('.button-remove-category');

const form = document.querySelector('#modalCreateChangeCategory form');
const hiddenInputPreviousCategory = document.querySelector('#modalCreateChangeCategory #previousCategory');

const iconsToChoseInModal = document.querySelectorAll('.icon-to-chosen-in-modal')

for (let buttonAddNewElement of buttonsAddingNewElement) {
    buttonAddNewElement.addEventListener('click', function () {
        modalCreateAndChangeElement.toggle();
        form.action = '/settings/' + buttonAddNewElement.id;

        for (let icon of iconsToChoseInModal) {
            icon.checked = false;
        }
    })
}


for (let button of buttonsChangingElement) {
    button.addEventListener('click', function () {
        modalCreateAndChangeElement.toggle();

        let listOfCategories = button.parentElement.parentElement.parentElement;
        form.action = '/settings/' + listOfCategories.id;

        let chosenCategory = button.parentElement.parentElement;
        let idChosenCategory = chosenCategory.classList[0].slice(12);
        hiddenInputPreviousCategory.value = idChosenCategory;

        let nameIcon = chosenCategory.childNodes[2].textContent.slice(11, -73);
        let chosenCategoryIcon = document.getElementById(nameIcon);
        chosenCategoryIcon.checked = 'true';
    })
}


const buttonAddNewElementInModal = document.querySelector('#button-create-change-category-in-modal');
buttonAddNewElementInModal.addEventListener('click', function () {
    form.submit();
})