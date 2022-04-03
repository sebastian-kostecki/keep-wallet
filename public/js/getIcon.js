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

            let validator = $($(iconCheckButton).parent().parent()).validate();
            validator.element($(iconCheckButton).next());

            myModal.toggle();
        })
    })
}

const categoriesToChange = document.querySelectorAll('.category-to-change');
for (let category of categoriesToChange) {
    category.addEventListener('click', function () {
        let icon = category.nextElementSibling.childNodes[1].textContent.slice(1, -29);
        let name = category.nextElementSibling.innerText;

        category.parentElement.parentElement.lastElementChild.firstElementChild.innerHTML = icon;
        category.parentElement.parentElement.lastElementChild.firstElementChild.nextElementSibling.nextElementSibling.value = name.toLowerCase();
    })
}