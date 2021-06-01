import {renderMenuItems} from './menuItems';
import {renderForm} from './crudTable';
import {startOverlay, stopWait} from './wait';
import {showMessage} from './messages';


export let openModal = () => {

    let modal = document.getElementById('menu-item-modal');
    modal.classList.add('modal-active');
    
    startOverlay();
}

export let renderMenuItemForm = () => {

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
        
                try {
                    axios.post(url, data).then(response => {
        
                        menuItemFormContainer.innerHTML = response.data.form;
                        modal.classList.remove('modal-active');
                        id.value = "";
                        itemMenuForm.reset();
                        renderMenuItems();
                        renderForm();
                        stopWait();
                        showMessage('success', response.data.message);
                    });
                    
                } catch (error) {
        
                }
            };
        
            sendItemMenuPostRequest();
        });    
    }
}

