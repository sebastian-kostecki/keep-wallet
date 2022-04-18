const buttons = document.querySelectorAll('.button-change-budget-item');

for (let button of buttons) {
    button.addEventListener('click', function (e) {
        let classNameForTableData = 'td.' + button.id;
        let chosenTableDatas = document.querySelectorAll(classNameForTableData);
        for (let td of chosenTableDatas) {
            td.contentEditable = 'true';
        }
        button.hidden = true;
        let buttonChangingBudgetItem = button.nextElementSibling.lastElementChild;
        buttonChangingBudgetItem.style.display = 'inline-block';
    })

    button.parentElement.parentElement.addEventListener('mouseenter', function () {
        button.innerHTML = '<i class="fas fa-pen ms-1 fs-6"></i>';
    })

    button.parentElement.parentElement.addEventListener('mouseleave', function () {
        button.innerHTML = '';
    })
}

// const budgetItemInDetails = document.querySelectorAll('budget-item-details');
// for (let item of budgetItemInDetails) {
//     item.addEventListener('mouseenter', function () {
//         button.style.display = 'block';
//     })
// }



// var tds = document.getElementsByTagName('td');
// for (var i = 0; i < tds.length; i++) {
//     tds[i].contentEditable = 'true';
// }