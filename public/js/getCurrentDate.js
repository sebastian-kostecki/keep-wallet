const dateInput = document.querySelector('#date');
const currentDate = new Date();
dateInput.value = currentData.toISOString().substr(0, 10);