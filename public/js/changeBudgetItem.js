const buttons = document.querySelectorAll('.button-change-budget-item');

for (let button of buttons) {
    button.addEventListener('click', function () {
        let classNameForTableData = 'td.' + button.id;
        let chosenTableDatas = document.querySelectorAll(classNameForTableData);
        for (let td of chosenTableDatas) {
            td.contentEditable = 'true';
        }
        button.innerHTML = 'Zmień';
    })
}

// var tds = document.getElementsByTagName('td');
// for (var i = 0; i < tds.length; i++) {
//     tds[i].contentEditable = 'true';
// }