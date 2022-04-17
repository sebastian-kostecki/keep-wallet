const titlesOfSettings = document.querySelectorAll('.setting-list');
const settingsForm = document.querySelectorAll('.settings-form');

for (let title of titlesOfSettings) {
    title.addEventListener('click', function () {
        let classForm = '.' + title.id;
        let form = document.querySelector(classForm);
        let markDown = title.children[0].children[2].children[0];
        let markUp = title.children[0].children[2].children[1];

        if (form.style.display === 'block') {
            form.style.display = 'none';
            markUp.style.display = 'none';
            markDown.style.display = 'inline-block';
        } else {
            form.style.display = 'block';
            markUp.style.display = 'inline-block';
            markDown.style.display = 'none';
        }
    })
};