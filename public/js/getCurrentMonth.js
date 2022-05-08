const currentMonthInput = document.querySelector("#chosenPeriod");
const currentData = new Date();

const getCurrentMonthPeriod = () => {
    const currentData = new Date();
    currentData.setDate(1);
    const firstDayCurrentMonth = currentData.toISOString().slice(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 0);
    const lastDayCurrentMonth = currentData.toISOString().slice(0, 10);
    return firstDayCurrentMonth + "-" + lastDayCurrentMonth;
}

currentMonthInput.value = getCurrentMonthPeriod();

const selectPeriodCurrent = document.querySelector('#selectPeriodCurrent');
selectPeriodCurrent.value = "currentMonth";