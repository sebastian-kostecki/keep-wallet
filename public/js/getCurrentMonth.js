const currentMonthInput = document.querySelector("#chosenPeriod");
const currentData = new Date();

const getCurrentMonthPeriod = () => {
    const currentData = new Date();
    currentData.setDate(2);
    const firstDayCurrentMonth = currentData.toISOString().slice(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 1);
    const lastDayCurrentMonth = currentData.toISOString().slice(0, 10);
    console.log(firstDayCurrentMonth)
    console.log(lastDayCurrentMonth)
    return firstDayCurrentMonth + "-" + lastDayCurrentMonth;
}

currentMonthInput.value = getCurrentMonthPeriod();

const selectPeriodCurrent = document.querySelector('#selectPeriodCurrent');
selectPeriodCurrent.value = "currentMonth";