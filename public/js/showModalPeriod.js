const selectDatePeriod = document.querySelector("select");
//const currentData = new Date();

const currentMonthPeriod = () => {
    const currentData = new Date();
    currentData.setDate(1);
    const firstDayCurrentMonth = currentData.toISOString().substr(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 0);
    const lastDayCurrentMonth = currentData.toISOString().substr(0, 10);
    return firstDayCurrentMonth + "-" + lastDayCurrentMonth;
}

const previousMonthPeriod = () => {
    const currentData = new Date();
    currentData.setMonth(currentData.getMonth() - 1, 1);
    const firstDayPreviousMonth = currentData.toISOString().substr(0, 10);
    currentData.setMonth(currentData.getMonth() + 1, 0);
    const lastDayPreviousMonth = currentData.toISOString().substr(0, 10);
    return firstDayPreviousMonth + "-" + lastDayPreviousMonth;
}

const currentYear = () => {
    const currentData = new Date();
    currentData.setMonth(0, 1);
    const firstDayCurrentYear = currentData.toISOString().substr(0, 10);
    currentData.setMonth(11, 31);
    const lastDayCurrentYear = currentData.toISOString().substr(0, 10);
    return firstDayCurrentYear + "-" + lastDayCurrentYear;
}

selectDatePeriod[0].value = currentMonthPeriod();
selectDatePeriod[1].value = previousMonthPeriod();
selectDatePeriod[2].value = currentYear();

const myModal = new bootstrap.Modal(document.getElementById('periodModal'), {
    keyboard: false
})
const chosenPeriodForm = document.querySelector('#choosePeriod');
const selectPeriod = document.querySelector('#selectPeriod');

const sendSelectValue = () => {
    showModal();
    if (selectDatePeriod.value == selectDatePeriod[0].value) {
        selectPeriod.value = 'currentMonth';
        chosenPeriodForm.submit();
    } else if (selectDatePeriod.value == selectDatePeriod[1].value) {
        selectPeriod.value = 'previousMonth';
        chosenPeriodForm.submit();
    } else if (selectDatePeriod.value == selectDatePeriod[2].value) {
        selectPeriod.value = 'currentYear';
        chosenPeriodForm.submit();
    }
}

const showModal = () => {
    if ((selectDatePeriod.value != selectDatePeriod[0].value) && (selectDatePeriod.value != selectDatePeriod[1].value) && (selectDatePeriod.value != selectDatePeriod[2].value)) {
        myModal.toggle();
    }
}


const startDate = document.querySelector('#startDate');
const endDate = document.querySelector('#endDate');
const selectDateButton = document.querySelector('#selectDate');

selectDateButton.addEventListener('click', function () {
    selectDatePeriod[3].value = startDate.value + '-' + endDate.value;
    selectDatePeriod[3].innerText = convertDate(startDate.value) + ' - ' + convertDate(endDate.value);
    myModal.toggle();
    selectPeriod.value = 'nonStandard';
    chosenPeriodForm.submit();
})

const convertDate = (inputFormat) => {
    const pad = (s) => ((s < 10) ? '0' + s : s)
    const d = new Date(inputFormat)
    return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('.')
}

const convertDisplayDate = (inputDate) => {
    let beginning = inputDate.slice(0, 10);
    let end = inputDate.slice(11);
    beginning = convertDate(beginning);
    end = convertDate(end);
    return beginning + ' - ' + end;
}

if (selectDatePeriod[3].selected == true) {
    selectDatePeriod[3].innerText = convertDisplayDate(selectDatePeriod[3].innerText.trim())
}
