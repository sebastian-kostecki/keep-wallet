const buttons = document.querySelectorAll('.button-change-budget-item');
const buttonsChangingBudgetItems = document.querySelectorAll('.button-form-change-budget-item');

const isButtonsNotShowing = () => {
    for (let button of buttonsChangingBudgetItems) {
        if (button.style.display == 'inline-block') {
            return false;
        }
    }
    return true;
}


for (let button of buttons) {
    button.addEventListener('click', function (e) {
        if (isButtonsNotShowing()) {
            let classNameForTableData = 'td.' + button.id;
            let chosenTableDatas = document.querySelectorAll(classNameForTableData);
            for (let td of chosenTableDatas) {
                td.contentEditable = 'true';
            }
            button.hidden = true;
            let buttonAbortingBudgetItem = button.nextElementSibling.lastElementChild;
            let buttonChangingBudgetItem = button.nextElementSibling.lastElementChild.previousElementSibling;

            buttonAbortingBudgetItem.style.display = 'inline-block';
            buttonChangingBudgetItem.style.display = 'inline-block';
        }
    })

    button.parentElement.parentElement.addEventListener('mouseenter', function () {
        if (isButtonsNotShowing()) {
            button.innerHTML = '<i class="fas fa-pen ms-2 fs-6"></i>';
        }
    })

    button.parentElement.parentElement.addEventListener('mouseleave', function () {
        button.innerHTML = '';
    })
}

const formsChangingBudgetItems = document.querySelectorAll('.form-change-budget-item');
for (let form of formsChangingBudgetItems) {
    form.addEventListener('submit', function () {
        let incomeId = form.previousElementSibling.id.slice(10);
        let incomeDate = form.parentElement.nextElementSibling.textContent;
        let incomeAmount = form.parentElement.nextElementSibling.nextElementSibling.textContent.slice(0, -3);
        let incomeComment = form.parentElement.parentElement.nextElementSibling.firstElementChild.textContent;
        form.children.id.value = incomeId;
        form.children.date.value = incomeDate;
        form.children.amount.value = incomeAmount;
        form.children.comment.value = incomeComment;
    })
}