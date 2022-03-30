const buttonChosenIconInModal = document.querySelector('#button-chosen-icon-in-modal');
const iconCheckButtons = document.querySelectorAll('.button-chosen-icon');
const chosenIcon = document.querySelectorAll('.selected-icon-in-modal');
const hiddenInputs = document.querySelectorAll('.chosen-icon-input-value');

const myModal = new bootstrap.Modal(document.getElementById('choiceIncomeIcon'), {
    keyboard: false
})




for (let iconCheckButton of iconCheckButtons) {
    iconCheckButton.addEventListener('click', function () {

        //działa tylko dla wybranego buttona
        buttonChosenIconInModal.addEventListener('click', function () {
            let chosenIcon = document.querySelector('.selected-icon-in-modal:checked').value;
            iconCheckButton.innerHTML = '<i class="' + chosenIcon + '">';
            myModal.toggle();
        })

        //let chosenIcon = document.querySelector('.selected-icon-in-modal:checked').value;

        //iconCheckButton.innerHTML = '<i class="' + chosenIcon + '">';

        //console.log(hiddenInput.value);
        //myModal.toggle();
    })


}



