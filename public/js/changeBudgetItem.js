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

