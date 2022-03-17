const hiddenPassword = document.querySelector(".hidden-password");
const showedPassword = document.querySelector(".showed-password");
const inputPassword = document.querySelector("#password-input");

hiddenPassword.addEventListener('click', event => {
    hiddenPassword.style.display = 'none';
    showedPassword.style.display = 'inline-block';
    inputPassword.type = 'text';
});

showedPassword.addEventListener('click', event => {
    hiddenPassword.style.display = 'inline-block';
    showedPassword.style.display = 'none';
    inputPassword.type = 'password';
});