export let renderTable = () => {

    let tableContainer = document.getElementById("table");
    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    
    document.addEventListener("loadTable",( event =>{
        
        tableContainer.classList.add('table-hide');
        tableContainer.innerHTML = event.detail.table;

        setTimeout(function(){
            table.classList.remove('table-hide');
        }, 500)
    }));

    document.addEventListener("renderTableModules",( event =>{
        renderTable();
    }), {once: true});

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

                document.dispatchEvent(new CustomEvent('openModalDelete', {
                    detail: {
                        url: deleteButton.dataset.url,
                    }
                }));

                document.dispatchEvent(new CustomEvent('startOverlay'));
            });
        });
    
        
    }
};

