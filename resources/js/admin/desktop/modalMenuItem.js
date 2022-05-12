export let renderModalMenuItem = () => {

    let menuItemStoreButton = document.getElementById('modal-menu-item-store-button');

    if(menuItemStoreButton){

        menuItemStoreButton.addEventListener("click", (e) => {
            
            let menuItemFormContainer = document.getElementById('menu-item-form-container');
            let modal = document.getElementById('menu-item-modal');
            let itemMenuForm = document.getElementById('menu-item-form');
            let url = itemMenuForm.action;
            let data = new FormData(itemMenuForm);
            let id = document.getElementById('modal-image-id');
        
            let sendItemMenuPostRequest = async () => {

                let response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                    method: 'POST',
                    body: data
                })
                .then(response => {
                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                    menuItemFormContainer.innerHTML = json.form;
                    modal.classList.remove('modal-active');
                    id.value = "";
                    itemMenuForm.reset();

                    document.dispatchEvent(new CustomEvent('loadTable', {
                        detail: {
                            table: json.table,
                        }
                    }));

                    document.dispatchEvent(new CustomEvent('renderFormModules'));
                    document.dispatchEvent(new CustomEvent('stopWait'));

                    document.dispatchEvent(new CustomEvent('message', {
                        detail: {
                            message: json.message,
                            type: 'success'
                        }
                    }));
                })
                .catch ( error =>  {

                    document.dispatchEvent(new CustomEvent('stopWait'));

                    if(error.status == '422'){
    
                        error.json().then(jsonError => {

                            let errors = jsonError.errors;      
                            let errorMessage = '';
        
                            Object.keys(errors).forEach(function(key) {
                                errorMessage += '<li>' + errors[key] + '</li>';
                            })
            
                            document.dispatchEvent(new CustomEvent('message', {
                                detail: {
                                    message: errorMessage,
                                    type: 'success'
                                }
                            }));
                        })   
                    }

                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
        
            sendItemMenuPostRequest();
        });    
    }

}

export let openModal = () => {

    let modal = document.getElementById('menu-item-modal');
    modal.classList.add('modal-active');
    
    document.dispatchEvent(new CustomEvent('startOverlay'));
}


