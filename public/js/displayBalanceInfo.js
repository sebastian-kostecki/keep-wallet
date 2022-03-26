const balance = document.querySelector('#balance-sum');
const balanceInfo = document.querySelector('.balance-info');
const balanceText = document.querySelector('.balance-text');

if (balance.innerText >= 0) {
    balanceInfo.style.backgroundColor = '#17966C';
    balanceText.innerText = "Świetnie zarządzasz finansami";
} else {
    balanceInfo.style.backgroundColor = '#FA3454';
    balanceText.innerText = "Wpadasz w długi!";
}