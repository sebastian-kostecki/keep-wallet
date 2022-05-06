const showLimit = document.querySelector('#show-limit')
const categoryName = document.querySelector('#category-name')
const categoryLimit = document.querySelector('#category-limit')
const categorySpent = document.querySelector('#category-spent')
const categoryRemainded = document.querySelector('#category-remainded')

const selectCategoryButton = document.querySelectorAll('.select-category-button')
for (let radioButton of selectCategoryButton) {
    radioButton.addEventListener('change', function () {
        let categoryId = radioButton.value;

        axios
            .get(`/expense/getLimit/${categoryId}`)
            .then((data) => {
                console.log(data.data);
                console.log(radioButton.id)

                if (data.data.limit_category) {
                    showLimit.classList.remove('d-none')
                    categoryName.textContent = radioButton.id;
                    categoryLimit.textContent = data.data.limit_category;
                } else if (!showLimit.classList.contains('d-none')) {
                    showLimit.classList.add('d-none');
                }
            })
    })

}

