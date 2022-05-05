const selectCategoryButton = document.querySelectorAll('.select-category-button')
for (let radioButton of selectCategoryButton) {


    radioButton.addEventListener('change', function () {
        let categoryId = radioButton.value;

        axios
            .get(`/expense/getLimit/${categoryId}`)
            .then((data) => {
                console.log(data.data);
            })
    })

}

