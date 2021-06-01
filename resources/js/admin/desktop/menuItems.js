import {openModal, renderMenuItemForm} from './modalMenuItem';
import {startOverlay} from './wait';
import {renderSelects} from './selects';

export let renderMenuItems = () => {

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

                    try {
                        axios.get(url, {
                            params: {
                              'language': language
                            }
                        }).then(response => {
                                
                            modalContainer.innerHTML = response.data.form;
                            document.getElementById('menu-item-language').value = language;
                            document.getElementById('menu-id').value = menu;
                            renderSelects();
                            renderMenuItemForm();

                            setTimeout(function(){ 
                                openModal()}
                            , 200);
                        });
                        
                    } catch (error) {
            
                    }
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
    
                    try {
                        await axios.get(url).then(response => {
                            modalContainer.innerHTML = response.data.form;
                            renderSelects();
                            renderMenuItemForm();
                            
                            setTimeout(function(){ 
                                openModal()}
                            , 200);
                        });
                        
                    } catch (error) {
                        console.error(error);
                    }
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
                startOverlay();
            });
        });
    }
}