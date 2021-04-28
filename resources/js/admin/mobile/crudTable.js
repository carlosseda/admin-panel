import {renderCkeditor} from './ckeditor';
import {swipeRevealItem} from './swipe';
import {scrollWindowElement} from './verticalScroll';
import {startWait, stopWait} from './wait';
import {showMessage} from './messages';
import {showForm} from './bottombarMenu';

const table = document.getElementById("table");
const form = document.getElementById("form");

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let labels = document.querySelectorAll('.label-highlight');
    let inputs = document.querySelectorAll('.input-highlight');
    let storeButton = document.getElementById('store-button');
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
        
        if(onOffSwitch.value == true){
            onOffSwitch.value = false;
        }else{
            onOffSwitch.value = true;
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

        event.preventDefault();
    
        forms.forEach(form => { 
            
            let data = new FormData(form);

            if( ckeditors != 'null'){

                Object.entries(ckeditors).forEach(([key, value]) => {
                    data.append(key, value.getData());
                });
            }

            let url = form.action;
    
            let sendPostRequest = async () => {
    
                try {
                    await axios.post(url, data).then(response => {
                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;
                        
                        stopWait();
                        showMessage('success', response.data.message);
                        renderTable();
                    });
                    
                } catch (error) {
    
                    if(error.response.status == '422'){
    
                        let errors = error.response.data.errors;      
                        let errorMessage = '';
    
                        Object.keys(errors).forEach(function(key) {
                            errorMessage += '<li>' + errors[key] + '</li>';
                        })
        
                        showMessage('validation', errorMessage);
                    }
                }
            };
    
            sendPostRequest();
        });
    });
    
    renderCkeditor();
};

export let renderTable = () => {

    let swipeRevealItemElements = document.querySelectorAll('.swipe-element');

    swipeRevealItemElements.forEach(swipeRevealItemElement => {

        new swipeRevealItem(swipeRevealItemElement);

    });
}; 

export let verticalScrollTable = () => {
    
    new scrollWindowElement(table);

}


export let deleteElement = (url) => {

    let modalDelete = document.getElementById('modal-delete');
    let deleteConfirm = document.getElementById('delete-confirm');

    deleteConfirm.dataset.url = url;
    modalDelete.classList.add('open');
}

export let editElement = (url) => {
    
    let sendEditRequest = async () => {

        showForm();

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
}

renderForm();
renderTable();
verticalScrollTable();


