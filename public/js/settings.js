//add and change category
const modalCreateAndChangeElement = new bootstrap.Modal(document.getElementById('modalCreateChangeCategory'), {
    keyboard: false
})

const buttonsAddingNewElement = document.querySelectorAll('.button-add-element');
for (let button of buttonsAddingNewElement) {
    button.addEventListener('click', function () {
        button.setModulName();
        modalCreateAndChangeElement.toggle();
        button.setActionInForm();
        clearSelectedRadioInput();
        clearCategoryNameInput();
        clearCategoryIcon();
        clearLimit();
        sendForm();
    })
}

const buttonsChangingElement = document.querySelectorAll('.button-change-category');
for (let button of buttonsChangingElement) {
    button.addEventListener('click', function () {
        button.setModulName();
        modalCreateAndChangeElement.toggle();
        button.setActionInForm();
        button.setChosenCategoryIdInHiddenInput();
        button.setIconOfSelectedItem();
        button.setNameCategoryOfSelectedItem();
        button.setLimitFieldForSelectedItem();
        sendForm();
    })
}

HTMLElement.prototype.setModulName = function () {
    const modalHeading = document.querySelector('#modalAddChangeElementLabel')
    const nameOfAction = this.id.split('-')[0]
    if (nameOfAction == 'change') {
        modalHeading.textContent = 'Edycja kategorii'
    } else {
        modalHeading.textContent = 'Dodawanie nowej kategorii'
    }
}

HTMLElement.prototype.setActionInForm = function () {
    const form = document.querySelector('#form-add-change-category');
    form.action = '/settings/' + this.id;
}

HTMLElement.prototype.setChosenCategoryIdInHiddenInput = function () {
    const hiddenInputPreviousCategory = document.querySelector('#previousCategoryId');
    let selectedCategory = this.parentElement.parentElement;
    let idChosenCategory = selectedCategory.classList[0].slice(12);
    hiddenInputPreviousCategory.value = idChosenCategory;
}

HTMLElement.prototype.setIconOfSelectedItem = function () {
    let selectedCategory = this.parentElement.parentElement;
    let nameIcon = 'fas ' + selectedCategory.querySelector('svg').classList[1];

    let selectedCategoryIcon = document.getElementById(nameIcon);
    selectedCategoryIcon.checked = 'true';

    const fieldWithIcon = document.querySelector('#button-triggering-modal-chosen-icon');
    fieldWithIcon.innerHTML = '<i class=" ' + nameIcon + ' "></i>'

    const hiddenInputWithIcon = document.querySelector('#hiddenInputWithIcon');
    hiddenInputWithIcon.value = nameIcon;
}

HTMLElement.prototype.setNameCategoryOfSelectedItem = function () {
    let selectedCategory = this.parentElement.parentElement;
    let nameCategory = selectedCategory.querySelector('.category-name').innerText.trim();
    const nameCategoryInput = document.querySelector('#nameCategory')
    nameCategoryInput.value = nameCategory.capitalizeFirstLetter()
}

HTMLElement.prototype.setLimitFieldForSelectedItem = function () {
    let selectedCategory = this.parentElement.parentElement;
    const setLimitCheckbox = document.querySelector('#setLimitCheckbox');
    const setLimitInput = document.querySelector('#setLimitInput');
    let limitCategoryElement = selectedCategory.querySelector('.limit-category');

    if (limitCategoryElement) {
        setLimitCheckbox.checked = true
        setLimitInput.disabled = false
        setLimitInput.value = limitCategoryElement.textContent.slice(7, -3)
    } else {
        setLimitCheckbox.checked = false
        setLimitInput.disabled = true
        setLimitInput.value = ''
    }
}

const clearSelectedRadioInput = () => {
    const iconsToChoseInModal = document.querySelectorAll('.icon-to-chosen-in-modal');
    for (let icon of iconsToChoseInModal) {
        icon.checked = false;
    }
}

const clearCategoryNameInput = () => {
    const categoryNameInput = document.querySelector('[name="nameCategory"]');
    categoryNameInput.value = '';
}

const clearCategoryIcon = () => {
    let fieldWithIcon = document.querySelector('#button-triggering-modal-chosen-icon');
    fieldWithIcon.textContent = 'Wybierz ikonę'
}

const clearLimit = () => {
    setLimitInput.disabled = true;
    setLimitInput.value = ''
    setLimitCheckbox.checked = false;
}

const sendForm = () => {
    const form = document.querySelector('#form-add-change-category');
    const button = document.querySelector('#button-add-change');
    button.addEventListener('click', function () {
        let validator = $(form).validate();
        if (validator.form()) {
            form.submit();
        }
    })
}


//remove category
const buttonsRemovingElement = document.querySelectorAll('.button-remove-category');
for (let button of buttonsRemovingElement) {
    button.addEventListener('click', function () {
        const modalRemoveElement = new bootstrap.Modal(document.getElementById('confirmRemoving'), {
            keyboard: false
        })
        modalRemoveElement.toggle();
        button.setActionInRemoveForm();
        button.setChosenCategoryIdInHiddenRemoveInput();
        sendRemoveForm();
    })
}

HTMLElement.prototype.setActionInRemoveForm = function () {
    const form = document.querySelector('#confirmRemoving form');
    form.action = '/settings/' + this.id;
}

HTMLElement.prototype.setChosenCategoryIdInHiddenRemoveInput = function () {
    const hiddenInputPreviousCategory = document.querySelector('#categoryIdToRemove');
    let selectedCategory = this.parentElement.parentElement;
    let idChosenCategory = selectedCategory.classList[0].slice(12);
    hiddenInputPreviousCategory.value = idChosenCategory;
}

const sendRemoveForm = () => {
    const form = document.querySelector('#confirmRemoving form');
    const button = document.querySelector('#button-remove');
    button.addEventListener('click', function () {
        form.submit();
    })
}

const validateForm = (form) => {
    let validator = $(form).validate();
    validator.form();
}

String.prototype.capitalizeFirstLetter = function () {
    return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase();
}

//select icon
const modalChosenIcon = new bootstrap.Modal(document.getElementById('iconsModal'), {
    keyboard: false
})

const buttonSelectedIconInModalWithIcons = document.querySelector('#button-chosen-icon');
buttonSelectedIconInModalWithIcons.addEventListener('click', function () {
    assignSelectedIconToButton();
    modalChosenIcon.toggle();
    modalCreateAndChangeElement.toggle();
    validateSelectedIcon();
})

const assignSelectedIconToButton = () => {
    const inputsWithIcons = document.querySelectorAll('.icon-to-chosen-in-modal');
    for (let inputRadio of inputsWithIcons) {
        if (inputRadio.checked === true) {
            const buttonTriggeringModalChosenIcon = document.querySelector('#button-triggering-modal-chosen-icon');
            const hiddenInputWithIcon = document.querySelector('#hiddenInputWithIcon');

            buttonTriggeringModalChosenIcon.innerHTML = '<i class=" ' + inputRadio.value + ' "></i>'
            hiddenInputWithIcon.value = inputRadio.value;
        }
    }
}

const validateSelectedIcon = () => {
    const form = document.querySelector('#form-add-change-category');
    const hiddenInputWithIcon = document.querySelector('#hiddenInputWithIcon');
    let validator = $(form).validate();
    validator.element($(hiddenInputWithIcon));
}


//hide and show limit field
const buttonsAddingOrChangingCategory = document.querySelectorAll('.button-change-category,.button-add-element');
for (let button of buttonsAddingOrChangingCategory) {
    button.addEventListener('click', function () {
        let positionOfFirstDash = button.id.indexOf('-')
        let positionOfLastDash = button.id.lastIndexOf('-')
        let nameOfBudgetItem = button.id.slice(positionOfFirstDash + 1, positionOfLastDash);

        const setLimitField = document.querySelector('.set-limit-field');
        if (nameOfBudgetItem == 'expense') {
            setLimitField.classList.remove("d-none")
        } else {
            setLimitField.classList.add("d-none");
        }
    })

}


//enabled or disabled limit field
const setLimitCheckbox = document.querySelector('#setLimitCheckbox')
const setLimitInput = document.querySelector('#setLimitInput')

setLimitCheckbox.addEventListener('click', function () {
    if (setLimitCheckbox.checked == true) {
        setLimitInput.disabled = false
    } else {
        setLimitInput.disabled = true
        setLimitInput.value = ''
    }
})