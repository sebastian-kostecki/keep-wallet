const settingList = document.querySelectorAll('.setting-list');
const settingsForm = document.querySelectorAll('.settings-form');

for (let legend of settingList) {
    legend.addEventListener('click', function () {
        for (let form of settingsForm) {
            if (legend.id == form.id && form.style.display == 'flex') {
                form.style.display = 'none';
            } else {
                form.style.display = 'flex';
            }
        }
    })
};