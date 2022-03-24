const expensesName = document.querySelectorAll('.expense-name');
const expensesCategories = [];
for (let expenseName of expensesName) {
    expensesCategories.push(expenseName.innerText);
}

const expensesSums = document.querySelectorAll('.expense-cash');
const expensesAmounts = [];
for (let expensesAmount of expensesSums) {
    expensesAmounts.push(parseFloat(expensesAmount.innerText));
}

const data = {
    labels: expensesCategories,
    datasets: [{
        label: 'My First dataset',
        backgroundColor: [
            '#f94144',
            '#f3722c',
            '#f8961e',
            '#f9844a',
            '#f9c74f',
            '#90be6d',
            '#43aa8b',
            '#4d908e',
            '#577590',
            '#277da1'
        ],
        data: expensesAmounts,
    }]
};

const config = {
    type: 'pie',
    data: data,
    options: {
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    color: 'rgba(255,255,255, 0.55)',
                    font: {
                        size: 16
                    }
                }
            }
        }
    }
};

const expensesChart = new Chart(
    document.querySelector('#expensesChart'),
    config
);

