const currentMonthInput = document.querySelector("#currentMonth");
const currentData = new Date();

const getCurrentMonthPeriod = () => {
    const currentData = new Date();
    currentData.setDate(1);
    const firstDayCurrentMonth = currentData.toISOString().substr(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 0);
    const lastDayCurrentMonth = currentData.toISOString().substr(0, 10);
    return firstDayCurrentMonth + "-" + lastDayCurrentMonth;
}

currentMonthInput.value = getCurrentMonthPeriod();