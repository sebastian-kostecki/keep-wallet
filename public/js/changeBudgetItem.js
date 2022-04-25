const showAndHideChangeAndRemoveButton = (firstRow) => {
    let secondRow = firstRow.nextElementSibling;
    firstRow.addEventListener('mouseenter', function () {
        this.firstElementChild.firstElementChild.style.display = 'block';
    })
    secondRow.addEventListener('mouseenter', function () {
        this.previousElementSibling.firstElementChild.firstElementChild.style.display = 'block';
    })
    firstRow.addEventListener('mouseleave', function () {
        this.firstElementChild.firstElementChild.style.display = 'none';
    })
    secondRow.addEventListener('mouseleave', function () {
        this.previousElementSibling.firstElementChild.firstElementChild.style.display = 'none';
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
        console.log(input.id.slice(7));
        console.log(firstRow.classList[4].slice(12));
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


//ma działać - DZIAŁA
const rowOfBudgetItems = document.querySelectorAll('.budget-item');
for (let budgetItem of rowOfBudgetItems) {
    showAndHideChangeAndRemoveButton(budgetItem);
}

//do zmiany
//ma wywołac odpowiedni modal
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


//działa - wysyła modal
const buttonsConfirmModal = document.querySelectorAll('.button-confirm-modal');
for (let button of buttonsConfirmModal) {
    button.addEventListener('click', function () {
        let form = button.parentElement.previousElementSibling.firstElementChild;
        form.submit();
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
            formRemoveBudgetItem.action = '/' + button.classList[0].slice(0, -5) + '/remove';
            formRemoveBudgetItem.firstElementChild.value = button.classList[0].slice(10);
            formRemoveBudgetItem.submit();
        })
    })
}