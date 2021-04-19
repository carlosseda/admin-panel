import {renderTable} from './crudTable';

let modalDelete = document.getElementById('modal-delete');
let deleteConfirm = document.getElementById('delete-confirm');
let deleteCancel = document.getElementById('delete-cancel');

deleteCancel.addEventListener("click", () => {
    modalDelete.classList.remove('open');
});

deleteConfirm.addEventListener("click", () => {

    let url = deleteConfirm.dataset.url;

    let sendDeleteRequest = async () => {

        try {
            await axios.delete(url).then(response => {
                table.innerHTML = response.data.table;
                modalDelete.classList.remove('open');
                renderTable();
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendDeleteRequest();
});