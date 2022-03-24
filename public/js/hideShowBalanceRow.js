const rows = document.querySelectorAll('.category-row');
const budgetItems = document.querySelectorAll('.budget-item-details');

for (let row of rows) {
    row.addEventListener('click', function () {
        row.style.color = 'black'
    })
}