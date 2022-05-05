const selectCategoryButton = document.querySelectorAll('.select-category-button')
for (let radioButton of selectCategoryButton) {


    radioButton.addEventListener('change', function () {
        let categoryId = radioButton.value;

        axios
            .get(`/expense/getLimit/${categoryId}`)
            .then((data) => {
                console.log(data.data);

                if (data.data.limit_category) {
                    const limitInfo = document.createElement('h1');
                    const form = document.querySelector('.budget-form');
                    form.prepend(limitInfo);

                    limitInfo.textContent = data.data.limit_category;
                }
            })
    })

}

