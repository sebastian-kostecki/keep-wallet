const showAndHideChangeAndRemoveButton = (firstRow) => {
    let secondRow = firstRow.nextElementSibling;

    firstRow.addEventListener('mouseenter', function () {
        let icons = firstRow.firstElementChild.firstElementChild;
        icons.style.display = 'block';
    })
    secondRow.addEventListener('mouseenter', function () {
        let icons = firstRow.firstElementChild.firstElementChild;
        icons.style.display = 'block';
    })
    firstRow.addEventListener('mouseleave', function () {
        let icons = firstRow.firstElementChild.firstElementChild;
        icons.style.display = 'none';
    })
    secondRow.addEventListener('mouseleave', function () {
        let icons = firstRow.firstElementChild.firstElementChild;
        icons.style.display = 'none';
    })
}

const formatDate = (date) => {
    let day = parseInt(date.slice(0, 2)) + 1;
    let month = parseInt(date.slice(3, 5)) - 1;
    let year = date.slice(6);
    let cleanDate = new Date(year, month, day);
    return cleanDate.toISOString().slice(0, 10);
}

const assignValuesFromTableToModal = (changeButton, modal) => {
    let firstRow = changeButton.parentElement.parentElement.parentElement;
    let modalForm = modal.querySelector('.budget-form');
    assignId(firstRow, modalForm);
    assignDate(firstRow, modalForm);
    assignAmount(firstRow, modalForm);
    assignCategory(firstRow, modalForm);
    assignPaymentMethod(firstRow, modalForm);
    assignComment(firstRow, modalForm);
}

const assignId = (firstRow, modalForm) => {
    let idInput = modalForm.querySelector('#id');
    idInput.value = firstRow.classList[5].slice(10);
}

const assignDate = (firstRow, modalForm) => {
    let dateInput = modalForm.querySelector('#date');
    let dateCell = firstRow.querySelector('.budget-item-date');
    dateInput.value = formatDate(dateCell.textContent);
}

const assignAmount = (firstRow, modalForm) => {
    let amountInput = modalForm.querySelector('#amount');
    let amountCell = firstRow.querySelector('.budget-item-amount');
    amountInput.value = amountCell.textContent.slice(0, -3);
}

const assignCategory = (firstRow, modalForm) => {
    let categoryInputs = modalForm.querySelectorAll('[name="category"]');
    for (let input of categoryInputs) {
        if (input.id.slice(7) == firstRow.classList[4].slice(12)) {
            input.checked = 'true';
        }
    }
}

const assignComment = (firstRow, modalForm) => {
    let commentInput = modalForm.querySelector('#comment');
    let commentCell = firstRow.nextElementSibling.querySelector('.budget-item-comment');
    commentInput.value = commentCell.textContent;
}

const assignPaymentMethod = (firstRow, modalForm) => {
    let paymentMethodInputs = modalForm.querySelectorAll('[name="paymentMethod"]');
    let paymentMethodCell = firstRow.querySelector('.budget-item-payment-method');
    if (paymentMethodInputs.length != 0) {
        for (let input of paymentMethodInputs) {
            if (input.id.slice(3) == paymentMethodCell.classList[1].slice(18)) {
                input.checked = 'true';
            }
        }
    }
}

const rowOfBudgetItems = document.querySelectorAll('.budget-item');
for (let budgetItem of rowOfBudgetItems) {
    showAndHideChangeAndRemoveButton(budgetItem);
}


const modalChangeIncome = new bootstrap.Modal(document.getElementById('changeIncomeModal'), {
    keyboard: false
});
const modalChangeIncomeElement = document.querySelector('#changeIncomeModal');
const buttonsChangeIncome = document.querySelectorAll('.button-change-income');
for (let button of buttonsChangeIncome) {
    button.addEventListener('click', function () {
        modalChangeIncome.toggle();
        assignValuesFromTableToModal(button, modalChangeIncomeElement);
    })
}

const modalChangeExpense = new bootstrap.Modal(document.getElementById('changeExpenseModal'), {
    keyboard: false
})
const modalChangeExpenseElement = document.querySelector('#changeExpenseModal');
const buttonsChangeExpense = document.querySelectorAll('.button-change-expense');
for (let button of buttonsChangeExpense) {
    button.addEventListener('click', function () {
        modalChangeExpense.toggle();
        assignValuesFromTableToModal(button, modalChangeExpenseElement);
    })
}

const buttonsConfirmModal = document.querySelectorAll('.button-confirm-modal');
for (let button of buttonsConfirmModal) {
    button.addEventListener('click', function () {
        let form = button.parentElement.previousElementSibling.firstElementChild;
        let validator = $(form).validate();
        if (validator.form()) {
            form.submit();
        }
    })
}

const modalRemoveElement = new bootstrap.Modal(document.getElementById('confirmRemoving'), {
    keyboard: false
})
const buttonsRemoveBudgetItem = document.querySelectorAll('.button-remove');
const buttonConfirmRemove = document.querySelector('#button-remove');
const formRemoveBudgetItem = document.querySelector('#form-remove');
for (let button of buttonsRemoveBudgetItem) {
    button.addEventListener('click', function () {
        modalRemoveElement.toggle();

        buttonConfirmRemove.addEventListener('click', function () {
            formRemoveBudgetItem.action = '/' + button.classList[0] + '/remove';
            formRemoveBudgetItem.firstElementChild.value = button.classList[1].slice(10);
            formRemoveBudgetItem.submit();
        })
    })
}