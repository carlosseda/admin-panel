import {renderCkeditor} from './ckeditor';
import {startWait, stopWait} from './wait';
import {showMessage} from './messages';

const table = document.getElementById("table");
const form = document.getElementById("form");

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let labels = document.querySelectorAll('.label-highlight');
    let inputs = document.querySelectorAll('.input-highlight');
    let storeButton = document.getElementById("store-button");
    let createButton = document.getElementById("create-button");
    let onOffSwitch = document.getElementById('onoffswitch');

    inputs.forEach(input => {

        input.addEventListener('focusin', () => {
    
            for( var i = 0; i < labels.length; i++ ) {
                if (labels[i].htmlFor == input.name){
                    labels[i].classList.add("active");
                }
            }
        });
    
        input.addEventListener('blur', () => {
    
            for( var i = 0; i < labels.length; i++ ) {
                labels[i].classList.remove("active");
            }
        });
    });

    onOffSwitch.addEventListener("click", () => {

        if(onOffSwitch.value == "true"){
            onOffSwitch.value = "false";
        }else{
            onOffSwitch.value = "true";
        }
    });

    createButton.addEventListener("click", (event) => {

        let url = createButton.dataset.url;

        let sendCreateRequest = async () => {

            startWait();

            try {
                await axios.get(url).then(response => {

                    form.innerHTML = response.data.form;
                    renderForm();
                    stopWait();
                });
                
            } catch (error) {

                stopWait();

                if(error.response.status == '500'){
                
                }
            }
        };

        sendCreateRequest();
    });

    storeButton.addEventListener("click", (event) => {
    
        forms.forEach(form => { 
            
            let data = new FormData(form);
            let url = form.action;

            if( ckeditors != 'null'){

                Object.entries(ckeditors).forEach(([key, value]) => {
                    data.append(key, value.getData());
                });
            }

            let sendPostRequest = async () => {

                startWait();
    
                try {
                    await axios.post(url, data).then(response => {

                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;

                        stopWait();
                        showMessage('success', response.data.message);
                        renderTable();
                    });
                    
                } catch (error) {
    
                    stopWait();

                    if(error.response.status == '422'){
    
                        let errors = error.response.data.errors;      
                        let errorMessage = '';
    
                        Object.keys(errors).forEach(function(key) {
                            errorMessage += '<li>' + errors[key] + '</li>';
                        })
        
                        showMessage('validation', errorMessage);
                    }

                    if(error.response.status == '500'){
                    
                    }
                }
            };
    
            sendPostRequest();
        });
    });
    
    renderCkeditor();
};

export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let modalDelete = document.getElementById('modal-delete');
    let deleteConfirm = document.getElementById('delete-confirm');
    let deleteCancel = document.getElementById('delete-cancel');
    let paginationButtons = document.querySelectorAll('.table-pagination-button');

    editButtons.forEach(editButton => {

        editButton.addEventListener("click", () => {

            let url = editButton.dataset.url;

            let sendEditRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form;
                        renderForm();
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
            deleteConfirm.dataset.url = url;
            modalDelete.classList.add('open');
        });
    });

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

    paginationButtons.forEach(paginationButton => {

        paginationButton.addEventListener("click", () => {

            let url = paginationButton.dataset.pagination;

            let sendPaginationRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendPaginationRequest();
            
        });
    });
};

renderForm();
renderTable();


