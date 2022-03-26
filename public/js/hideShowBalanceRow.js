const rows = document.querySelectorAll('.category-row');
const budgetItems = document.querySelectorAll('.budget-item-details');

for (let row of rows) {
    row.addEventListener('click', function () {
        //console.log(row.innerText);
        //row.innerText -> obie wartości przedzielone /t
        //czyli trzeba wyodrębnić części do tabulatora

        let lineFromRow = row.innerText.split('\t');
        //lineFromRow[0] -> to nazwa klasy ze spacjami

        let words = lineFromRow[0].split(' ');

        let className = "";
        for (let word of words) {
            className += "." + word;
        }

        const elementsToDisplay = document.querySelectorAll(className);

        for (let elementToDisplay of elementsToDisplay) {
            if (elementToDisplay.style.display === 'table-row') {
                elementToDisplay.style.display = 'none';
            } else {
                elementToDisplay.style.display = 'table-row';
            }
        }
    })

    let lineFromRow = row.innerText.split('\t');
    //lineFromRow[0] -> to nazwa klasy ze spacjami

    let words = lineFromRow[0].split(' ');

    let className = "";
    for (let word of words) {
        className += "." + word;
    }

    const elementsToDisplay = document.querySelectorAll(className);
    for (let i = 0; i < elementsToDisplay.length; i++) {
        if ((i % 4 == 2) || (i % 4 == 3)) {
            elementsToDisplay[i].style.backgroundColor = "rgba(255, 255, 255, 0.05)";
        }
    }

}

// for (let i = 0; i < budgetItems.length; i++) {
//     if (i % 2 == 1) {
//         budgetItems[i].style.borderBottom = "1px solid rgba(255, 255, 255, 0.1";
//     }
// }

