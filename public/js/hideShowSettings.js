const titlesOfSettings = document.querySelectorAll('.setting-list');
const settingsForm = document.querySelectorAll('.settings-form');

for (let titles of titlesOfSettings) {
    titles.addEventListener('click', function () {
        let classForm = '.' + titles.id;
        let form = document.querySelector(classForm);
        let markDown = titles.children[0].children[1].children[0];
        let markUp = titles.children[0].children[1].children[1];

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