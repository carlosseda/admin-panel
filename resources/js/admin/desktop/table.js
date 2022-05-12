export let renderTable = () => {

    let tableContainer = document.getElementById("table");
    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let modalDelete = document.getElementById('modal-delete');
    let deleteConfirm = document.getElementById('delete-confirm');
    let deleteCancel = document.getElementById('delete-cancel');
    
    document.addEventListener("loadTable",( event =>{
        
        tableContainer.classList.add('table-hide');
        tableContainer.innerHTML = event.detail.table;

        setTimeout(function(){
            table.classList.remove('table-hide');
        }, 500)
    }));

    document.addEventListener("renderTableModules",( event =>{
        renderTable();
    }));

    if(editButtons){

        editButtons.forEach(editButton => {

            editButton.addEventListener("click", () => {
    
                let url = editButton.dataset.url;

                let sendEditRequest = async () => {
    
                    document.dispatchEvent(new CustomEvent('startWait'));
                    
                    let response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        method: 'GET', 
                    })
                    .then(response => {
                                  
                        if (!response.ok) throw response;

                        return response.json();
                    })
                    .then(json => {

                        document.dispatchEvent(new CustomEvent('loadForm', {
                            detail: {
                                form: json.form,
                            }
                        }));

                        document.dispatchEvent(new CustomEvent('renderFormModules'));
                        document.dispatchEvent(new CustomEvent('stopWait'));
                    })
                    .catch(error =>  {
    
                        document.dispatchEvent(new CustomEvent('stopWait'));
    
                        if(error.status == '500'){
                            console.log(error);
                        };
                    });
                };
    
                sendEditRequest();
            });
        });
    }

    if(deleteButtons){

        deleteButtons.forEach(deleteButton => {

            deleteButton.addEventListener("click", () => {
    
                let url = deleteButton.dataset.url;
                deleteConfirm.dataset.url = url;
                modalDelete.classList.add('modal-active');
                document.dispatchEvent(new CustomEvent('startOverlay'));
            });
        });
    
        deleteCancel.addEventListener("click", () => {
            modalDelete.classList.remove('modal-active');
            document.dispatchEvent(new CustomEvent('stopWait'));
        });
    
        deleteConfirm.addEventListener("click", () => {
    
            let url = deleteConfirm.dataset.url;
        
            let sendDeleteRequest = async () => {
    
                let response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    method: 'GET', 
                })
                .then(response => {
                              
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                    if(json.table){
                        tableContainer.innerHTML = json.table;
                    }

                    document.dispatchEvent(new CustomEvent('loadForm', {
                        detail: {
                            form: json.form,
                        }
                    }));

                    modalDelete.classList.remove('modal-active');

                    document.dispatchEvent(new CustomEvent('renderFormModules'));
                    document.dispatchEvent(new CustomEvent('renderTableModules'));

                    document.dispatchEvent(new CustomEvent('stopWait'));
                    document.dispatchEvent(new CustomEvent('message', {
                        detail: {
                            message: json.message,
                            type: 'success'
                        }
                    }));
                })
                .catch(error =>  {

                    document.dispatchEvent(new CustomEvent('stopWait'));

                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
    
            sendDeleteRequest();
        });    
    }
};

