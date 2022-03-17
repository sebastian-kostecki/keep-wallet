const hiddenPassword = document.querySelector(".hidden-password");
const showedPassword = document.querySelector(".showed-password");

hiddenPassword.addEventListener('click', event => {
    hiddenPassword.style.display = 'none';
    showedPassword.style.display = 'inline-block';
});

showedPassword.addEventListener('click', event => {
    hiddenPassword.style.display = 'inline-block';
    showedPassword.style.display = 'none';
});