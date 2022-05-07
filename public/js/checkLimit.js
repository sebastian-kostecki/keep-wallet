const getCurrentMonthPeriods = (date) => {
    let day = parseInt(date.slice(9, 10));
    let month = parseInt(date.slice(6, 7)) - 1;
    let year = date.slice(0, 4);
    let currentData = new Date(year, month, day);
    currentData.setDate(2);
    const firstDayCurrentMonth = currentData.toISOString().slice(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 1);
    const lastDayCurrentMonth = currentData.toISOString().slice(0, 10);
    return firstDayCurrentMonth + "-" + lastDayCurrentMonth;
}

const isAmountValid = (value) => {
    value *= 1000;
    if (value % 10 == 0 && value > 0) {
        return true;
    }
    return false;
}

const showLimit = document.querySelector('#show-limit')
const categoryName = document.querySelector('#category-name')
const categoryLimit = document.querySelector('#category-limit')
const categorySpent = document.querySelector('#category-spent')
const categoryRemainded = document.querySelector('#category-remainded')
const headingRemainded = document.querySelector('#heading-remainded');

const showInfoAfterExpense = document.querySelector('#show-info-after-expense');
const headingAfterExpense = document.querySelector('#info-after-expense-heading');
const amountAfterExpense = document.querySelector('#info-after-expense-amount');

const selectCategoryButton = document.querySelectorAll('.select-category-button')
for (let radioButton of selectCategoryButton) {
    radioButton.addEventListener('change', function () {
        let categoryId = radioButton.value;

        axios
            .get(`/expense/getLimit/${categoryId}`)
            .then((data) => {
                if (data.data.limit_category) {
                    showLimit.classList.remove('d-none')
                    categoryName.textContent = radioButton.id;
                    categoryLimit.textContent = data.data.limit_category;
                    console.log(data.data.limit_category);

                    //pobranie sumy wydatków podanej kategorii z określonego zakresu dat
                    //pobieram początek i koniec na podstawie wybranej daty
                    let dateElement = document.querySelector('#date');
                    let DateFormat = dateElement.value;
                    let date = getCurrentMonthPeriods(DateFormat);

                    //wysyłamy żądanie zawierające id kategorii oraz zakres dat
                    axios
                        .get(`/expense/expenses/${categoryId}?date=${date}`)
                        .then((d) => {
                            console.log(d.data.sum);
                            categorySpent.textContent = d.data.sum;

                            //wpisujemy różnicę
                            if (data.data.limit_category - d.data.sum > 0) {
                                headingRemainded.textContent = "Pozostało: ";
                                categoryRemainded.textContent = (data.data.limit_category - d.data.sum).toFixed(2);
                                showLimit.classList.remove('bg-danger');
                                showLimit.classList.add('bg-success');
                            } else {
                                headingRemainded.textContent = "Przekroczono: ";
                                categoryRemainded.textContent = (d.data.sum - data.data.limit_category).toFixed(2);
                                showLimit.classList.remove('bg-success');
                                showLimit.classList.add('bg-danger');
                            }

                            //wyświetlamy albo nie podsumowanie w oparciu o kwotę
                            //sytuacja, gdy najpierw wpiszemy kwotę
                            const amountInput = document.querySelector('#amount');
                            if (isAmountValid(amountInput.value)) {
                                showInfoAfterExpense.classList.remove('d-none');

                                //liczymy jaki będzie bilans pomiedzy tym co pozostało a nowym wydatkiem
                                if ((data.data.limit_category - d.data.sum).toFixed(2) - amountInput.value > 0) {
                                    headingAfterExpense.textContent = "Do limitu pozostanie ";
                                    amountAfterExpense.textContent = (data.data.limit_category - d.data.sum).toFixed(2) - amountInput.value;
                                    showLimit.classList.remove('bg-danger');
                                    showLimit.classList.add('bg-success');
                                } else {
                                    headingAfterExpense.textContent = "Przekroczysz limit o ";
                                    amountAfterExpense.textContent = amountInput.value - (data.data.limit_category - d.data.sum).toFixed(2);
                                    showLimit.classList.remove('bg-success');
                                    showLimit.classList.add('bg-danger');
                                }

                            } else {
                                showInfoAfterExpense.classList.add('d-none');
                            }

                            //sytuacja, gdy najpierw wybierzemy kategorie a potem kwotę
                            amountInput.addEventListener('change', function () {
                                if (isAmountValid(amountInput.value)) {
                                    showInfoAfterExpense.classList.remove('d-none');

                                    if ((data.data.limit_category - d.data.sum).toFixed(2) - amountInput.value > 0) {
                                        headingAfterExpense.textContent = "Do limitu pozostanie ";
                                        amountAfterExpense.textContent = (data.data.limit_category - d.data.sum).toFixed(2) - amountInput.value;
                                        showLimit.classList.remove('bg-danger');
                                        showLimit.classList.add('bg-success');
                                    } else {
                                        headingAfterExpense.textContent = "Przekroczysz limit o ";
                                        amountAfterExpense.textContent = amountInput.value - (data.data.limit_category - d.data.sum).toFixed(2);
                                        showLimit.classList.remove('bg-success');
                                        showLimit.classList.add('bg-danger');
                                    }
                                } else {
                                    showInfoAfterExpense.classList.add('d-none');
                                }
                            })
                        })

                } else if (!showLimit.classList.contains('d-none')) {
                    showLimit.classList.add('d-none');
                }
            })
    })

}

