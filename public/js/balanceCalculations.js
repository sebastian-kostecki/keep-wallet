const expensesAmount = document.querySelectorAll('.expense-amount');
const incomesAmount = document.querySelectorAll('.income-amount');
const incomesSum = document.querySelector('#incomes-sum');
const expensesSum = document.querySelector('#expenses-sum');

let sumIncomes = 0;
let sumExpenses = 0;

for (const income of incomesAmount) {
    sumIncomes = sumIncomes + parseFloat(income.innerText);
}

incomesSum.innerText = sumIncomes.toFixed(2) + " zł";

for (const expense of expensesAmount) {
    sumExpenses += parseFloat(expense.innerText);
}

expensesSum.innerText = sumExpenses.toFixed(2) + " zł";

const balanceSum = document.querySelector('#balance-sum');
balanceSum.innerText = (sumIncomes - sumExpenses).toFixed(2);