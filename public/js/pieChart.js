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
            '#9DD9E2',
            '#C3A1C1',
            '#F7F5B0',
            '#FCC4B0',
            '#BBD5D3',
            '#F4ABBA',
            '#F2E2BA',
            '#E7CBDB',
            '#F6918A',
            '#82C9C7',
            '#E7E4DE',
            '#55C4C5',
            '#FBC19C'
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

