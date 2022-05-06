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

const showLimit = document.querySelector('#show-limit')
const categoryName = document.querySelector('#category-name')
const categoryLimit = document.querySelector('#category-limit')
const categorySpent = document.querySelector('#category-spent')
const categoryRemainded = document.querySelector('#category-remainded')

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

                    //pobranie sumy wydatków podanej kategorii z określonego zakresu dat
                    //pobieram początek i koniec na podstawie wybranej daty
                    let dateElement = document.querySelector('#date');
                    let DateFormat = dateElement.value;
                    console.log(DateFormat);
                    console.log(getCurrentMonthPeriods(DateFormat)) //to jest format pierwszy - ostatni
                    let date = getCurrentMonthPeriods(DateFormat);

                    //wysyłamy żądanie zawierające id kategorii oraz zakres dat
                    axios
                        .get(`/expense/expenses/${categoryId}?date=${date}`)
                        .then((d) => {
                            console.log(d.data.sum);
                            categorySpent.textContent = d.data.sum;
                        })


                } else if (!showLimit.classList.contains('d-none')) {
                    showLimit.classList.add('d-none');
                }
            })
    })

}

