import {openModal, renderMenuItemForm} from './modalMenuItem';

export let renderMenuItems = () => {

    document.addEventListener("renderFormModules",( event =>{
        renderMenuItems();
    }));

    let createButtons = document.querySelectorAll('.menu-item-create');
    let editButtons = document.querySelectorAll('.menu-item-edit');
    let deleteButtons = document.querySelectorAll('.menu-item-delete');
    let modalDelete = document.getElementById('modal-delete');
    let deleteConfirm = document.getElementById('delete-confirm');

    if(createButtons){

        createButtons.forEach(createButton => {
        
            createButton.addEventListener('click', () => {

                let url = createButton.dataset.url;
                let language = createButton.dataset.language; 
                let menu = createButton.dataset.menu; 
                let modalContainer = document.getElementById('menu-item-modal-container');

                let sendMenuItemRequest = async () => {

                    let response = await fetch(url.searchParams.append(language, language), {
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
    
                        modalContainer.innerHTML = json.form;
                        document.getElementById('menu-item-language').value = language;
                        document.getElementById('menu-id').value = menu;
                        document.dispatchEvent(new CustomEvent('renderFormModules'));
                        renderMenuItemForm();

                        setTimeout(function(){ 
                            openModal()}
                        , 200);

                    })
                    .catch(error =>  {
        
                        if(error.status == '500'){
                            console.log(error);
                        };
                    });

                };
        
                sendMenuItemRequest();

            });
        });
    }

    if(editButtons){

        editButtons.forEach(editButton => {

            editButton.addEventListener("click", () => {
    
                let modalContainer = document.getElementById('menu-item-modal-container');
                let url = editButton.dataset.route + '/' + editButton.dataset.id;
    
                let sendEditRequest = async () => {
    
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
    
                        modalContainer.innerHTML = response.data.form;
                        document.dispatchEvent(new CustomEvent('renderFormModules'));
                        renderMenuItemForm();

                        setTimeout(function(){ 
                            openModal()}
                        , 200);
                    })
                    .catch(error =>  {
        
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
    
                let url = deleteButton.dataset.route + '/' + deleteButton.dataset.id;
                deleteConfirm.dataset.url = url;
                modalDelete.classList.add('modal-active');
                document.dispatchEvent(new CustomEvent('startOverlay'));
            });
        });
    }
}