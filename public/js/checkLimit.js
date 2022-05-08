const selectCategoryButton = document.querySelectorAll('.select-category-button')
for (let radio of selectCategoryButton) {
    radio.addEventListener('change', showLimit)
}

async function showLimit() {
    let categoryId = this.value;
    let limitCategory = await getLimit(categoryId);
    if (limitCategory) {
        let sumOfCategory = await getSumOfCategory(categoryId);
        showLimitInformation(categoryId, limitCategory, sumOfCategory);
        showDifferenceAfterTypingAmount(limitCategory, sumOfCategory);
    } else {
        hideWindowWithInformationsAboutLimit();
    }
}

const getLimit = async (categoryId) => {
    let response = await axios.get(`/api/limit/${categoryId}`);
    return response.data.limit_category;
}

const getSumOfCategory = async (categoryId) => {
    let selectedPeriod = getDateOfSelectedPeriod();
    let response = await axios.get(`/api/expenses/${categoryId}?date=${selectedPeriod}`);
    return response.data.sum;
}

const getDateOfSelectedPeriod = () => {
    let dateElement = document.querySelector('#date');
    let dateRangeToDisplay = dateElement.value;
    let dateRangeToDatabase = dateRangeToDisplay.convertDateToDatabaseFormat();
    return dateRangeToDatabase;
}

String.prototype.convertDateToDatabaseFormat = function () {
    let day = this.slice(8);
    let month = this.slice(6, 7);
    let year = this.slice(0, 4);
    let date = new Date(year, month - 1, day);
    date.setDate(2);
    const firstDay = date.toISOString().slice(0, 10);
    date.setMonth(date.getMonth() + 1, 1);
    const lastDay = date.toISOString().slice(0, 10);
    return firstDay + "-" + lastDay;
}

const showLimitInformation = (id, limit, sum) => {
    showWindowWithInformationsAboutLimit();
    changeWindowWithInformationAboutLimitColor(limit, sum);
    assignName(id);
    assignLimit(limit);
    assignSum(sum);
    assignDifference(limit, sum);
}

const showWindowWithInformationsAboutLimit = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#show-limit');
    windowWithInformationsAboutLimit.classList.remove('d-none');
}

const assignName = (id) => {
    const categoryName = document.querySelector('#category-name');
    const selectedButton = document.querySelector(`.select-category-button[value="${id}"]`)
    categoryName.textContent = selectedButton.id;
}

const assignLimit = (limit) => {
    const categoryLimit = document.querySelector('#category-limit');
    categoryLimit.textContent = limit;
}

const assignSum = (sum) => {
    const categorySpent = document.querySelector('#category-spent');
    categorySpent.textContent = sum;
}

const assignDifference = (limit, sum) => {
    let difference = limit - sum;
    if (difference >= 0) {
        difference.assignRemaindedAmount();
    } else {
        difference.assignExceededAmount();
    }
}

const changeWindowWithInformationAboutLimitColor = (limit, sum) => {
    let difference = limit - sum;
    if (difference >= 0) { changeColorToSuccess() }
    else { changeColorToDanger() }
}

Number.prototype.assignRemaindedAmount = function () {
    const categoryRemainded = document.querySelector('#category-remainded')
    const headingRemainded = document.querySelector('#heading-remainded');
    headingRemainded.textContent = "Pozostało: ";
    categoryRemainded.textContent = this.toFixed(2);
}

Number.prototype.assignExceededAmount = function () {
    const categoryRemainded = document.querySelector('#category-remainded')
    const headingRemainded = document.querySelector('#heading-remainded');
    headingRemainded.textContent = "Przekroczono: ";
    categoryRemainded.textContent = Math.abs(this).toFixed(2);
}

const changeColorToSuccess = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#show-limit');
    windowWithInformationsAboutLimit.classList.remove('bg-danger');
    windowWithInformationsAboutLimit.classList.add('bg-success');
}

const changeColorToDanger = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#show-limit');
    windowWithInformationsAboutLimit.classList.remove('bg-success');
    windowWithInformationsAboutLimit.classList.add('bg-danger');
}

const showDifferenceAfterTypingAmount = (limit, sum) => {
    const amountInput = document.querySelector('#amount');
    showCurrentDifference(limit, sum);
    amountInput.addEventListener('change', () => { showCurrentDifference(limit, sum) });
}

const showCurrentDifference = (limit, sum) => {
    const amountInput = document.querySelector('#amount');
    let amount = amountInput.value;
    if (amount.isAmountCorrect()) {
        let initialDifference = limit - sum;
        let currentDifference = initialDifference - amount;
        if (currentDifference >= 0) {
            currentDifference.showRemaindedCurrentAmount();
            changeColorToSuccess();
        } else {
            currentDifference.showExceededCurrentAmount();
            changeColorToDanger();
        }
        showInformationAfterTypingAmount();
    } else {
        hideInformationAfterTypingAmount();
    }
}

String.prototype.isAmountCorrect = function () {
    if (this > 0 && this.isAmountCorrectFormat()) { return true }
    else { return false }
}

String.prototype.isAmountCorrectFormat = function () {
    let number = this * 1000;
    if (number % 10 == 0) { return true }
    return false;
}

Number.prototype.showRemaindedCurrentAmount = function () {
    const headingAfterExpense = document.querySelector('#info-after-expense-heading');
    const amountAfterExpense = document.querySelector('#info-after-expense-amount');
    headingAfterExpense.textContent = "Do limitu pozostanie ";
    amountAfterExpense.textContent = this.toFixed(2);
}

Number.prototype.showExceededCurrentAmount = function () {
    const headingAfterExpense = document.querySelector('#info-after-expense-heading');
    const amountAfterExpense = document.querySelector('#info-after-expense-amount');
    headingAfterExpense.textContent = "Przekroczysz limit o ";
    amountAfterExpense.textContent = Math.abs(this).toFixed(2);
}

const showInformationAfterTypingAmount = () => {
    const showInfoAfterExpense = document.querySelector('#show-info-after-expense');
    showInfoAfterExpense.classList.remove('d-none');
}

const hideInformationAfterTypingAmount = () => {
    const showInfoAfterExpense = document.querySelector('#show-info-after-expense');
    showInfoAfterExpense.classList.add('d-none');
}

const hideWindowWithInformationsAboutLimit = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#show-limit');
    windowWithInformationsAboutLimit.classList.add('d-none');
}