const dateInput = document.querySelector('#date');
const currentData = new Date();
dateInput.value = currentData.toISOString().substr(0, 10);