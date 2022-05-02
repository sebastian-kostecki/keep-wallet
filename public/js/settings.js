const modalCreateAndChangeElement = new bootstrap.Modal(document.getElementById('modalCreateChangeCategory'), {
    keyboard: false
})
const form = document.querySelector('#form-add-change-category');

const buttonsAddingNewElement = document.querySelectorAll('.button-add-element');
for (let button of buttonsAddingNewElement) {
    button.addEventListener('click', function () {
        modalCreateAndChangeElement.toggle();
        setActionInForm(button, form);
        clearChosenRadioInputs();
        clearCategoryNameInput();
        sendAddChangeForm(form);
    })
}

const buttonsChangingElement = document.querySelectorAll('.button-change-category');
const hiddenInputPreviousCategory = document.querySelector('#previousCategoryId');
for (let button of buttonsChangingElement) {
    button.addEventListener('click', function () {
        modalCreateAndChangeElement.toggle();
        setActionInForm(button, form);
        setChosenCategoryIdInHiddenInput(button, hiddenInputPreviousCategory);
        setIconChoosingElement(button);
        clearCategoryNameInput();
        sendAddChangeForm(form);
    })
}


const modalRemoveElement = new bootstrap.Modal(document.getElementById('confirmRemoving'), {
    keyboard: false
})
const buttonsRemovingElement = document.querySelectorAll('.button-remove-category');
const formRemove = document.querySelector('#confirmRemoving form');
const inputWithCategoryIdToRemove = document.querySelector('#categoryIdToRemove');

for (let button of buttonsRemovingElement) {
    button.addEventListener('click', function () {
        modalRemoveElement.toggle();
        setActionInForm(button, formRemove);
        setChosenCategoryIdInHiddenInput(button, inputWithCategoryIdToRemove);
        sendRemoveForm(formRemove);
    })
}


const setChosenCategoryIdInHiddenInput = (button, categoryId) => {
    let chosenCategory = button.parentElement.parentElement;
    let idChosenCategory = chosenCategory.classList[0].slice(12);
    categoryId.value = idChosenCategory;
}

const setActionInForm = (button, form) => {
    form.action = '/settings/' + button.id;
}

const setIconChoosingElement = (button) => {
    let chosenCategory = button.parentElement.parentElement;
    let nameIcon = chosenCategory.childNodes[2].textContent.slice(11, -73);
    let chosenCategoryIcon = document.getElementById(nameIcon);
    chosenCategoryIcon.checked = 'true';
}

const clearChosenRadioInputs = () => {
    const iconsToChoseInModal = document.querySelectorAll('.icon-to-chosen-in-modal');
    for (let icon of iconsToChoseInModal) {
        icon.checked = false;
    }
}

const clearCategoryNameInput = () => {
    const categoryNameInput = document.querySelector('[name="nameCategory"]');
    categoryNameInput.value = '';
}

const sendAddChangeForm = (form) => {
    const button = document.querySelector('#button-add-change');
    button.addEventListener('click', function () {
        let validator = $($(button).parent().parent().find('#form-add-change-category')).validate();
        if (validator.form()) {
            form.submit();
        }

    })
}

const sendRemoveForm = (form) => {
    const button = document.querySelector('#button-remove');
    button.addEventListener('click', function () {
        form.submit();
    })
}

const validateForm = (form) => {
    let validator = $(form).validate();
    validator.form();
}

//new code
const modalChosenIcon = new bootstrap.Modal(document.getElementById('iconsModal'), {
    keyboard: false
})
const buttonTriggeringModalChosenIcon = document.querySelector('#button-triggering-modal-chosen-icon');
const buttonChosenIcon = document.querySelector('#button-chosen-icon');
const hiddenInputWithIcon = document.querySelector('#hiddenInputWithIcon');

buttonChosenIcon.addEventListener('click', function () {
    const form = document.querySelector('#form-add-change-category');
    const inputsWithIcons = document.querySelectorAll('.icon-to-chosen-in-modal');
    for (let inputRadio of inputsWithIcons) {
        if (inputRadio.checked === true) {
            buttonTriggeringModalChosenIcon.innerHTML = '<i class=" ' + inputRadio.value + ' "></i>'
            hiddenInputWithIcon.value = inputRadio.value;
        }
    }
    modalChosenIcon.toggle();
    modalCreateAndChangeElement.toggle();
    validateForm(form);
})

//pokazanie ustalania limitu
const buttonsAddingOrChangingCategory = document.querySelectorAll('.button-change-category,.button-add-element');
const setLimitField = document.querySelector('.set-limit-field');
for (let button of buttonsAddingOrChangingCategory) {
    // console.log(button.id)
    // let positionOfFirstDash = button.id.indexOf('-')
    // let positionOfLastDash = button.id.lastIndexOf('-')
    // console.log(positionOfFirstDash);
    // console.log(positionOfLastDash);
    // console.log(button.id.slice(positionOfFirstDash + 1, positionOfLastDash))
    // let nameOfBudgetItem = button.id.slice(positionOfFirstDash + 1, positionOfLastDash);
    // console.log(nameOfBudgetItem);
    // console.log('');

    button.addEventListener('click', function () {
        let positionOfFirstDash = button.id.indexOf('-')
        let positionOfLastDash = button.id.lastIndexOf('-')
        let nameOfBudgetItem = button.id.slice(positionOfFirstDash + 1, positionOfLastDash);

        if (nameOfBudgetItem == 'expense') {
            console.log(nameOfBudgetItem);
            setLimitField.classList.remove("d-none")
        } else {
            setLimitField.classList.add("d-none");
        }
    })

}