import {openImageModal} from './modalImage';

export let renderUploadImage = () => {

    let inputElements = document.querySelectorAll(".upload-image-input");
    let uploadImages = document.querySelectorAll(".upload-image");

    inputElements.forEach(inputElement => {
    
        uploadImage(inputElement);
    });

    function uploadImage(inputElement){

        let uploadElement = inputElement.closest(".upload-image-add");

        uploadElement.addEventListener("click", (event) => {

            inputElement.click();
        });
      
        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(uploadElement, inputElement.files[0]);
            }
        });
      
        uploadElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadElement.classList.add("upload-image-over");
        });
      
        ["dragleave", "dragend"].forEach((type) => {
            uploadElement.addEventListener(type, (e) => {
                uploadElement.classList.remove("upload-image-over");
            });
        });
      
        uploadElement.addEventListener("drop", (e) => {
            e.preventDefault();
        
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(uploadElement, e.dataTransfer.files[0]);
            }
        
            uploadElement.classList.remove("upload-image-over");
        });
    }
      
    function updateThumbnail(uploadElement, file) {
    
        let thumbnailElement = uploadElement.querySelector(".upload-image-thumb");

        if(uploadElement.classList.contains('collection')){

            if(thumbnailElement == null){

                let cloneUploadElement = uploadElement.cloneNode(true);
                let cloneInput = cloneUploadElement.querySelector('.upload-image-input');

                uploadImage(cloneInput);
                uploadElement.parentElement.appendChild(cloneUploadElement);
            }
        }
    
        if (uploadElement.querySelector(".upload-image-prompt")) {
            uploadElement.querySelector(".upload-image-prompt").remove();
        }
        
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("upload-image-thumb");
            uploadElement.appendChild(thumbnailElement);
        }
                
        if (file.type.startsWith("image/")) {

            let reader = new FileReader();
        
            reader.readAsDataURL(file);
    
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };

            if(uploadElement.classList.contains('collection')){

                let content = uploadElement.dataset.content;
                let alias = uploadElement.dataset.alias;
                let inputElement = uploadElement.getElementsByClassName("upload-image-input")[0];
        
                inputElement.name = "images[" + content + "-" + Math.floor((Math.random() * 99999) + 1) + "." + alias  + "]"; 
            }
            
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }

    uploadImages.forEach(uploadImage => {
    
        uploadImage.addEventListener("click", (e) => {
            
            let url = uploadImage.dataset.url;
    
            let sendImageRequest = async () => {
    
                try {
                    axios.get(url).then(response => {

                        openImageModal(response.data);
                      
                    });
                    
                } catch (error) {
    
                }
            };
    
            sendImageRequest();

        });
    });
}
