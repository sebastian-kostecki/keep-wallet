const modalRemoveElement = new bootstrap.Modal(document.getElementById('confirmRemoving'), {
    keyboard: false
})

const buttons = document.querySelectorAll('.button-change-budget-item');
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

const assignTableCellToInputs = (form) => {
    let incomeId = form.previousElementSibling.firstElementChild.classList[0].slice(10);
    let incomeDate = formatDate(form.parentElement.nextElementSibling.textContent);
    let incomeAmount = form.parentElement.nextElementSibling.nextElementSibling.textContent.slice(0, -3);
    let incomeComment = form.parentElement.parentElement.nextElementSibling.firstElementChild.textContent;
    form.children.id.value = incomeId;
    form.children.date.value = incomeDate;
    form.children.amount.value = incomeAmount;
    form.children.comment.value = incomeComment;
}


// for (let button of buttons) {
//     button.addEventListener('click', function (e) {
//         if (isButtonsNotShowing()) {
//             let classNameForTableData = 'td.' + button.classList[0];
//             let chosenTableDatas = document.querySelectorAll(classNameForTableData);
//             for (let td of chosenTableDatas) {
//                 td.contentEditable = 'true';

//                 if (td.classList[0] == 'budget-item-comment') {
//                     if (td.textContent == '') {
//                         td.textContent = 'Komentarz';
//                         td.style.color = 'rgba(255,255,255,0.15)';
//                     }

//                     td.addEventListener('focus', function () {
//                         if (td.textContent == 'Komentarz') {
//                             td.textContent = '';
//                             td.style.color = 'inherit';
//                         }
//                     })

//                     td.addEventListener('blur', function () {
//                         if (td.textContent == '') {
//                             td.textContent = 'Komentarz';
//                             td.style.color = 'rgba(255,255,255,0.15)';
//                         }
//                     })
//                 }
//             }

//             let rememberedAmount = button.parentElement.parentElement.nextElementSibling.nextElementSibling.textContent;
//             let rememberedDate = button.parentElement.parentElement.nextElementSibling.textContent;
//             let rememberedComment = button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild.textContent;

//             button.hidden = true;
//             button.nextElementSibling.hidden = true;
//             let buttonAbortingBudgetItem = button.parentElement.nextElementSibling.lastElementChild;
//             let buttonChangingBudgetItem = button.parentElement.nextElementSibling.lastElementChild.previousElementSibling;

//             buttonAbortingBudgetItem.style.display = 'inline-block';
//             buttonChangingBudgetItem.style.display = 'inline-block';

//             buttonAbortingBudgetItem.addEventListener('click', function (e) {
//                 buttonAbortingBudgetItem.style.display = 'none';
//                 buttonChangingBudgetItem.style.display = 'none';
//                 for (let td of chosenTableDatas) {
//                     td.contentEditable = 'false';
//                 }

//                 button.parentElement.parentElement.nextElementSibling.nextElementSibling.textContent = rememberedAmount;
//                 button.parentElement.parentElement.nextElementSibling.textContent = rememberedDate;
//                 button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild.textContent = rememberedComment;
//                 if (button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild.textContent != 'Komentarz') {
//                     button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild.style.color = 'inherit';
//                 } else {
//                     button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild.style.display = 'none';
//                 }



//                 button.hidden = false;
//                 button.nextElementSibling.hidden = false;
//                 e.preventDefault();
//             })
//         }
//     })

//     button.nextElementSibling.addEventListener('click', function () {
//         modalRemoveElement.toggle();
//     })

//     buttonConfirmRemove.addEventListener('click', function () {
//         this.nextElementSibling.action = '/' + button.nextElementSibling.classList[0].slice(0, 6) + '/remove';
//         this.nextElementSibling.firstElementChild.value = button.classList[0].slice(10);
//         this.nextElementSibling.submit();
//     })


//     button.parentElement.parentElement.parentElement.addEventListener('mouseenter', function () {
//         if (isButtonsNotShowing()) {
//             button.parentElement.style.display = 'block';
//         }
//     })

//     button.parentElement.parentElement.parentElement.addEventListener('mouseleave', function () {
//         button.parentElement.style.display = 'none';
//     })
// }



// const formsChangingBudgetItems = document.querySelectorAll('.form-change-budget-item');
// for (let form of formsChangingBudgetItems) {
//     form.addEventListener('submit', function () {
//         let incomeId = form.previousElementSibling.firstElementChild.classList[0].slice(10);
//         let incomeDate = formatDate(form.parentElement.nextElementSibling.textContent);
//         let incomeAmount = form.parentElement.nextElementSibling.nextElementSibling.textContent.slice(0, -3);
//         let incomeComment = form.parentElement.parentElement.nextElementSibling.firstElementChild.textContent;
//         form.children.id.value = incomeId;
//         form.children.date.value = incomeDate;
//         form.children.amount.value = incomeAmount;
//         form.children.comment.value = incomeComment;
//     })
// }


//nowy kod
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
    if (element.textContent == '') {
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

const makeTableCellsEditable = (element) => {
    let date = element.parentElement.parentElement.nextElementSibling;
    let amount = element.parentElement.parentElement.parentElement.lastElementChild;
    let comment = element.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    date.contentEditable = 'true';
    amount.contentEditable = 'true';
    comment.contentEditable = 'true';
    showAndHideCommentPlaceholder(comment);
}

const makeTableCellsNotEditable = (element) => {
    let date = element.parentElement.parentElement.nextElementSibling;
    let amount = element.parentElement.parentElement.parentElement.lastElementChild;
    let comment = element.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    date.contentEditable = 'false';
    amount.contentEditable = 'false';
    comment.contentEditable = 'false';
}

const hideChangeAndRemoveButtons = (changeButton) => {
    changeButton.hidden = true;
    changeButton.nextElementSibling.hidden = true;
}

const showChangeAndRemoveButtons = (element) => {
    element.parentElement.previousElementSibling.firstElementChild.hidden = false;
    element.parentElement.previousElementSibling.lastElementChild.hidden = false;
}

const showConfirmAndAbortButtons = (changeButton) => {
    changeButton.parentElement.nextElementSibling.lastElementChild.style.display = 'inline-block';
    changeButton.parentElement.nextElementSibling.lastElementChild.previousElementSibling.style.display = 'inline-block';
}

const hideConfirmAndAbortButtons = (element) => {
    element.style.display = 'none';
    element.previousElementSibling.style.display = 'none';
}

const assignId = (form) => {
    let incomeId = form.classList[0].slice(10);
    form.children.id.value = incomeId;
}

const assignDate = (form) => {
    let incomeDate = formatDate(form.parentElement.nextElementSibling.textContent);
    form.children.date.value = incomeDate;
}

const assignAmount = (form) => {
    let incomeAmount = form.parentElement.parentElement.lastElementChild.textContent.slice(0, -3);
    form.children.amount.value = incomeAmount;
}

const assignComment = (form) => {
    let incomeComment = form.parentElement.parentElement.nextElementSibling.firstElementChild.textContent;
    if (incomeComment != 'Komentarz') {
        form.children.comment.value = incomeComment;
    } else {
        form.children.comment.value = '';
    }
}

let rememberedCells = {
    rememberedDate: 0,
    rememberedAmount: 0,
    rememberedComment: 0
}

const rememberChangingCells = (obj, button) => {
    let incomeAmount = button.parentElement.parentElement.parentElement.lastElementChild;
    let incomeDate = button.parentElement.parentElement.nextElementSibling;
    let incomeComment = button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    obj.rememberedAmount = incomeAmount.textContent;
    obj.rememberedDate = incomeDate.textContent;
    obj.rememberedComment = incomeComment.textContent;
}

const assignRememberedCells = (obj, button) => {
    let incomeAmount = button.parentElement.parentElement.parentElement.lastElementChild;
    let incomeDate = button.parentElement.parentElement.nextElementSibling;
    let incomeComment = button.parentElement.parentElement.parentElement.nextElementSibling.firstElementChild;
    incomeAmount.textContent = obj.rememberedAmount;
    incomeDate.textContent = obj.rememberedDate;
    incomeComment.textContent = obj.rememberedComment;
    if (incomeComment.textContent != 'Komentarz') {
        incomeComment.style.color = 'inherit';
    } else {
        incomeComment.style.display = 'none';
    }
    obj.rememberedAmount = 0;
    obj.rememberedDate = 0;
    obj.rememberedComment = 0;
}

const rowOfBudgetItems = document.querySelectorAll('.budget-item');
for (let budgetItem of rowOfBudgetItems) {
    showAndHideChangeAndRemoveButton(budgetItem);

    let changeButton = budgetItem.firstElementChild.firstElementChild.firstElementChild;
    changeButton.addEventListener('click', function (event) {
        if (checkIsOtherChangeButtonsHidden()) {
            makeTableCellsEditable(this);
            hideChangeAndRemoveButtons(this);
            showConfirmAndAbortButtons(this);
            rememberChangingCells(rememberedCells, this);
        }
    })

    let confirmChangesButton = budgetItem.firstElementChild.firstElementChild.nextElementSibling.lastElementChild.previousElementSibling;
    confirmChangesButton.addEventListener('click', function () {
        let form = this.parentElement;
        assignId(form);
        assignDate(form);
        assignAmount(form);
        assignComment(form);
        form.submit();
    })

    let abortChangesButton = budgetItem.firstElementChild.firstElementChild.nextElementSibling.lastElementChild;
    abortChangesButton.addEventListener('click', function (event) {
        hideConfirmAndAbortButtons(this);
        showChangeAndRemoveButtons(this);
        makeTableCellsNotEditable(this);
        assignRememberedCells(rememberedCells, this);
        event.preventDefault();
    })
}

const buttonsRemoveBudgetItem = document.querySelectorAll('.button-remove');
const buttonConfirmRemove = document.querySelector('#button-remove');
const formRemoveBudgetItem = document.querySelector('#form-remove');
for (let button of buttonsRemoveBudgetItem) {
    button.addEventListener('click', function () {
        modalRemoveElement.toggle();

        buttonConfirmRemove.addEventListener('click', function () {
            formRemoveBudgetItem.action = '/' + button.classList[0].slice(0, 6) + '/remove';
            formRemoveBudgetItem.firstElementChild.value = button.classList[0].slice(10);
            formRemoveBudgetItem.submit();
        })
    })

}