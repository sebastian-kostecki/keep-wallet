const buttonsChangingBudgetItems = document.querySelectorAll('.button-form-change-budget-item');
const checkIsOtherChangeButtonsHidden = () => {
    for (let button of buttonsChangingBudgetItems) {
        if (button.style.display == 'inline-block') {
            return false;
        }
    }
    return true;
}

const formatDate = (date) => {
    let day = parseInt(date.slice(0, 2)) + 1;
    let month = parseInt(date.slice(3, 5)) - 1;
    let year = date.slice(6);
    let cleanDate = new Date(year, month, day);
    return cleanDate.toISOString().slice(0, 10);
}

const showAndHideChangeAndRemoveButton = (firstRow) => {
    let secondRow = firstRow.nextElementSibling;
    firstRow.addEventListener('mouseenter', function () {
        if (checkIsOtherChangeButtonsHidden()) {
            this.firstElementChild.firstElementChild.style.display = 'block';
        }
    })
    secondRow.addEventListener('mouseenter', function () {
        if (checkIsOtherChangeButtonsHidden()) {
            this.previousElementSibling.firstElementChild.firstElementChild.style.display = 'block';
        }
    })
    firstRow.addEventListener('mouseleave', function () {
        this.firstElementChild.firstElementChild.style.display = 'none';
    })
    secondRow.addEventListener('mouseleave', function () {
        this.previousElementSibling.firstElementChild.firstElementChild.style.display = 'none';
    })
}

const showAndHideCommentPlaceholder = (element) => {
    if (element.textContent == '' || element.textContent == 'Komentarz') {
        element.textContent = 'Komentarz';
        element.style.color = 'rgba(255,255,255,0.15)';
    }
    element.addEventListener('focus', function () {
        if (this.textContent == 'Komentarz') {
            this.textContent = '';
            this.style.color = 'inherit';
        }
    })
    element.addEventListener('blur', function () {
        if (this.textContent == '') {
            this.textContent = 'Komentarz';
            this.style.color = 'rgba(255,255,255,0.15)';
        }
    })
}

const makeTableCellsEditable = (button) => {
    let firstRow = button.parentElement.parentElement.parentElement;
    let date = firstRow.querySelector('.budget-item-date');
    let amount = firstRow.querySelector('.budget-item-amount');
    let paymentMethod = firstRow.querySelector('.budget-item-payment-method');
    let comment = firstRow.nextElementSibling.firstElementChild;
    date.contentEditable = 'true';
    amount.contentEditable = 'true';
    if (paymentMethod != null) {
        paymentMethod.contentEditable = 'true';
    }
    comment.contentEditable = 'true';
    comment.style.display = 'table-cell';
    showAndHideCommentPlaceholder(comment);
}

const makeTableCellsNotEditable = (button) => {
    let firstRow = button.parentElement.parentElement.parentElement;
    let date = firstRow.querySelector('.budget-item-date');
    let amount = firstRow.querySelector('.budget-item-amount');
    let paymentMethod = firstRow.querySelector('.budget-item-payment-method');
    let comment = firstRow.nextElementSibling.firstElementChild;
    date.contentEditable = 'false';
    amount.contentEditable = 'false';
    if (paymentMethod != null) {
        paymentMethod.contentEditable = 'false';
    }
    comment.contentEditable = 'false';
}

const hideChangeAndRemoveButtons = (changeButton) => {
    let abortButton = changeButton.nextElementSibling;
    changeButton.hidden = true;
    abortButton.hidden = true;
}

const showChangeAndRemoveButtons = (abortChangeButton) => {
    let changeButton = abortChangeButton.parentElement.previousElementSibling.firstElementChild;
    let removeButton = abortChangeButton.parentElement.previousElementSibling.lastElementChild;
    changeButton.hidden = false;
    removeButton.hidden = false;
}

const showConfirmAndAbortButtons = (changeButton) => {
    let abortButton = changeButton.parentElement.nextElementSibling.lastElementChild;
    let confirmChangeButton = changeButton.parentElement.nextElementSibling.lastElementChild.previousElementSibling;
    abortButton.style.display = 'inline-block';
    confirmChangeButton.style.display = 'inline-block';
}

const hideConfirmAndAbortButtons = (abortChangeButton) => {
    let confirmChangeButton = abortChangeButton.previousElementSibling;
    abortChangeButton.style.display = 'none';
    confirmChangeButton.style.display = 'none';
}

// const assignId = (form) => {
//     let id = form.classList[0].slice(3);
//     form.children.id.value = id;
// }

// const assignDate = (form) => {
//     let budgetItemDate = form.parentElement.parentElement.querySelector('.budget-item-date');
//     let date = formatDate(budgetItemDate.textContent);
//     form.children.date.value = date;
// }

// const assignAmount = (form) => {
//     let budgetItemAmount = form.parentElement.parentElement.querySelector('.budget-item-amount');
//     let amount = budgetItemAmount.textContent.slice(0, -3);
//     form.children.amount.value = amount;
// }

// const assignPaymentMethod = (form) => {
//     let expensePaymentMethod = form.parentElement.parentElement.querySelector('.budget-item-payment-method');
//     if (expensePaymentMethod != null) {
//         let paymentMethod = expensePaymentMethod.textContent;
//         form.children.paymentMethod.value = paymentMethod;
//     }
// }

// const assignComment = (form) => {
//     let budgetItemComment = form.parentElement.parentElement.nextElementSibling.firstElementChild;
//     let comment = budgetItemComment.textContent;
//     if (comment != 'Komentarz') {
//         form.children.comment.value = comment;
//     } else {
//         form.children.comment.value = '';
//     }
// }

let rememberedCells = {
    rememberedDate: '',
    rememberedAmount: '',
    rememberedPaymentMethod: '',
    rememberedComment: ''
}

const rememberChangingCells = (obj, changeButton) => {
    let firstRow = changeButton.parentElement.parentElement.parentElement;
    let budgetItemAmount = firstRow.querySelector('.budget-item-amount');
    let budgetItemDate = firstRow.querySelector('.budget-item-date');
    let budgetItemPaymentMethod = firstRow.querySelector('.budget-item-payment-method');
    let budgetItemComment = changeButton.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    obj.rememberedAmount = budgetItemAmount.textContent;
    obj.rememberedDate = budgetItemDate.textContent;
    obj.rememberedComment = budgetItemComment.textContent;
    if (budgetItemPaymentMethod != null) {
        obj.rememberedPaymentMethod = budgetItemPaymentMethod.textContent;
    }
}

const assignRememberedCells = (obj, abortChangeButton) => {
    let firstRow = abortChangeButton.parentElement.parentElement.parentElement;
    let budgetItemAmount = firstRow.querySelector('.budget-item-amount');
    let budgetItemDate = firstRow.querySelector('.budget-item-date');
    let budgetItemPaymentMethod = firstRow.querySelector('.budget-item-payment-method');
    let budgetItemComment = abortChangeButton.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    budgetItemAmount.textContent = obj.rememberedAmount;
    obj.rememberedAmount = '';
    budgetItemDate.textContent = obj.rememberedDate;
    obj.rememberedDate = '';
    if (budgetItemPaymentMethod != null) {
        budgetItemPaymentMethod.textContent = obj.rememberedPaymentMethod;
        obj.rememberedPaymentMethod = '';
    }
    budgetItemComment.textContent = obj.rememberedComment;
    if (budgetItemComment.textContent != 'Komentarz') {
        budgetItemComment.style.color = 'inherit';
    } else {
        budgetItemComment.style.display = 'none';
    }
    obj.rememberedComment = '';
}




const assignValuesFromTableToModal = (changeButton) => {
    let firstRow = changeButton.parentElement.parentElement.parentElement;
    let modalForm = document.querySelector('#form-change-income');
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
    let categoryInputs = modalForm.querySelectorAll('.form-check-input');
    for (let input of categoryInputs) {
        if (input.id == firstRow.classList[4].slice(12)) {
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
const modalChangeElement = new bootstrap.Modal(document.getElementById('changeIncomeModal'), {
    keyboard: false
})

const buttonsChangeBudgetItem = document.querySelectorAll('.button-change-budget-item');
for (let button of buttonsChangeBudgetItem) {
    button.addEventListener('click', function () {
        if (checkIsOtherChangeButtonsHidden()) {
            modalChangeElement.toggle();
            assignValuesFromTableToModal(button);

            //makeTableCellsEditable(this);
            //hideChangeAndRemoveButtons(this);
            //showConfirmAndAbortButtons(this);
            //rememberChangingCells(rememberedCells, this);
        }
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

const buttonsConfirmChangeBudgetItem = document.querySelectorAll('.button-confirm-change');
for (let button of buttonsConfirmChangeBudgetItem) {
    button.addEventListener('click', function () {
        let form = this.parentElement;
        assignId(form);
        assignDate(form);
        assignAmount(form);
        assignPaymentMethod(form);
        assignComment(form);
        form.submit();
    })
}

const buttonsAbortChangeBudgetItem = document.querySelectorAll('.button-abort-change');
for (let button of buttonsAbortChangeBudgetItem) {
    button.addEventListener('click', function (event) {
        hideConfirmAndAbortButtons(this);
        showChangeAndRemoveButtons(this);
        makeTableCellsNotEditable(this);
        assignRememberedCells(rememberedCells, this);
        event.preventDefault();
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
            formRemoveBudgetItem.firstElementChild.value = button.classList[0].slice(-1);
            formRemoveBudgetItem.submit();
        })
    })
}