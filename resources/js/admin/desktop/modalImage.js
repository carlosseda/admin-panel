import {startOverlay, startWait, stopWait} from './wait';
import {showMessage} from './messages';

let modalImageStoreButton = document.getElementById('modal-image-store-button');
let modalImageDeleteButton = document.getElementById('modal-image-delete-button');

export let openImageModal = (image) => {

    let modal = document.getElementById('upload-image-modal');
    let imageContainer = document.getElementById('modal-image-original');
    let imageId = document.getElementById('modal-image-id');
    let imageFilename = document.getElementById('modal-image-filename');
    let imageEntityId = document.getElementById('modal-image-entity-id');
    let imageLanguage = document.getElementById('modal-image-language');
    let imageTitle = document.getElementById('modal-image-title');
    let imageAlt = document.getElementById('modal-image-alt');

    imageContainer.src = '../storage/' + image.path;
    imageFilename.value = image.filename;
    imageEntityId.value = image.entity_id;
    imageLanguage.value = image.language;
    imageId.value = image.id;
    imageTitle.value = image.title;
    imageAlt.value = image.alt;

    modal.classList.add('modal-active');

    startOverlay();
}

modalImageStoreButton .addEventListener("click", (e) => {
         
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
    let imageId = document.getElementById('modal-image-id').value;

    let sendImageDeleteRequest = async () => {

        try {
            axios.get(url, {
                params: {
                  'image': imageId
                }
            }).then(response => {

                modal.classList.remove('modal-active');
                stopWait();
                showMessage('success', response.data.message);

                let uploadImages = document.querySelectorAll(".upload-image");

                uploadImages.forEach(uploadImage => {

                    if(uploadImage.classList.contains(imageId)){

                        uploadImage.remove();
                    }
                
                });
        
            });
            
        } catch (error) {

        }
    };

    sendImageDeleteRequest();
});
