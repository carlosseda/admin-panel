const editButtons = document.querySelectorAll(".edit-button");
const deleteButtons = document.querySelectorAll(".delete-button");
const table = document.getElementById("table");

editButtons.forEach(editButton => {

    editButton.addEventListener("click", () => {

        let url = editButton.dataset.url;

        let sendEditRequest = async () => {

            try {
                await axios.get(url).then(response => {
                    form.innerHTML = response.data.form;
                });
                
            } catch (error) {
                console.error(error);
            }
        };

        sendEditRequest();
    });
});

deleteButtons.forEach(deleteButton => {

    deleteButton.addEventListener("click", () => {

        let url = deleteButton.dataset.url;

        let sendDeleteRequest = async () => {

            try {
                await axios.delete(url).then(response => {
                    table.innerHTML = response.data.table;
                });
                
            } catch (error) {
                console.error(error);
            }
        };

        sendDeleteRequest();
    });
});

