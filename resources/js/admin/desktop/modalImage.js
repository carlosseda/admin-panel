import {startOverlay, startWait, stopWait} from './wait';
import {showMessage} from './messages';
import {deleteThumbnail} from './uploadImage';

let modalImageStoreButton = document.getElementById('modal-image-store-button');
let modalImageDeleteButton = document.getElementById('modal-image-delete-button');

export let openModal = () => {

    let modal = document.getElementById('upload-image-modal');

    modal.classList.add('modal-active');
    startOverlay();
}

export let openImageModal = (image) => {

    let modal = document.getElementById('upload-image-modal');
    let imageContainer = document.getElementById('modal-image-original');
    let imageForm = document.getElementById('image-form');

    if(image.path){
        imageContainer.src = '../storage/' + image.path;
    }

    for (var [key, val] of Object.entries(image)) {

        let input = imageForm.elements[key];

        if(input){

            switch(input.type) {
                case 'checkbox': input.checked = !!val; break;
                default:         input.value = val;     break;
            }
        }
    }

    modal.classList.add('modal-active');

    startOverlay();
}

export let updateImageModal = (image) => {

    let imageContainer = document.getElementById('modal-image-original');
    imageContainer.src = image.dataset.image;

    let imageForm = document.getElementById('image-form');
    imageForm.reset();

    for (var [key, val] of Object.entries(image.dataset)) {

        let input = imageForm.elements[key];

        if(input){

            switch(input.type) {
                case 'checkbox': input.checked = !!val; break;
                default:         input.value = val;     break;
            }
        }
    }
}

modalImageStoreButton.addEventListener("click", (e) => {
         
    let modal = document.getElementById('upload-image-modal');
    let imageForm = document.getElementById('image-form');
    let data = new FormData(imageForm);
    let url = imageForm.action;

    let sendImagePostRequest = async () => {

        try {
            axios.post(url, data).then(response => {

                modal.classList.remove('modal-active');
                stopWait();
                showMessage('success', response.data.message);
              
            });
            
        } catch (error) {

        }
    };

    sendImagePostRequest();
});

modalImageDeleteButton.addEventListener("click", (e) => {
         
    let modal = document.getElementById('upload-image-modal');
    let url = modalImageDeleteButton.dataset.route;
    let temporalId = document.getElementById('modal-image-temporal-id').value;
    let entityId = document.getElementById('modal-image-entity-id').value;

    if(entityId){

        let sendImageDeleteRequest = async () => {

            try {
                axios.get(url, {
                    params: {
                      'image': imageId
                    }
                }).then(response => {
                    showMessage('success', response.data.message);
                });
                
            } catch (error) {
    
            }
        };
    
        sendImageDeleteRequest();

    }

    modal.classList.remove('modal-active');
    stopWait();
    deleteThumbnail(temporalId);
});
