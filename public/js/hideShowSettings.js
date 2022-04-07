const settingList = document.querySelectorAll('.setting-list');
const settingsForm = document.querySelectorAll('.settings-form');

for (let legend of settingList) {
    legend.addEventListener('click', function () {
        let classForm = '.' + legend.id;
        let form = document.querySelector(classForm);


        if (form.style.display === 'block') {
            form.style.display = 'none';
        } else {
            form.style.display = 'block';
        }
    })
};