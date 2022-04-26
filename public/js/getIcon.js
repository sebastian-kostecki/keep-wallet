const buttonChosenIconInModal = document.querySelector('#button-chosen-icon-in-modal');
const buttonsWithChoosingCategoryIcon = document.querySelectorAll('.button-chosen-icon');

const myModal = new bootstrap.Modal(document.getElementById('choiceIncomeIcon'), {
    keyboard: false
})

for (let iconCheckButton of buttonsWithChoosingCategoryIcon) {
    iconCheckButton.addEventListener('click', function () {
        buttonChosenIconInModal.addEventListener('click', function () {
            let chosenIcon = document.querySelector('.selected-icon-in-modal:checked');
            iconCheckButton.innerHTML = '<i class="' + chosenIcon.value + '">';
            iconCheckButton.nextElementSibling.value = chosenIcon.value;

            let validator = $($(iconCheckButton).parent().parent()).validate();
            validator.element($(iconCheckButton).next());

            myModal.toggle();
        })
    })
}


//zaznaczamy, że po kliknięciu w zmianę kategorii automatycznie wczytuje się ikonka
const categoriesToChange = document.querySelectorAll('.category-to-change');
for (let category of categoriesToChange) {
    category.addEventListener('click', function () {
        let icon = category.nextElementSibling.childNodes[1].textContent.slice(1, -29);
        category.parentElement.parentElement.lastElementChild.firstElementChild.innerHTML = icon;
        category.parentElement.parentElement.lastElementChild.children[1].value = icon.slice(10, -12);

        //to jest fomularz
        let validator = $($(category).parent().parent()).validate();

        //potrzebuje teraz zwalidować buttona z ikoną
        validator.element($(category).parent().parent().find('.chosen-icon-input-value'));
    })
}