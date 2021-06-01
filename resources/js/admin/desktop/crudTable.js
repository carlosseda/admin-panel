import {renderCkeditor} from './ckeditor';
import {startWait, stopWait, startOverlay} from './wait';
import {showMessage} from './messages';
import {renderTabs} from './tabs';
import {renderLocaleTabs} from './localeTabs';
import {renderLocaleTags} from './localeTags';
import {renderLocaleSeo} from './localeSeo';
import {renderGoogleBot} from './googleBot';
import {renderSitemap} from './sitemap';
import {renderUploadImage} from './uploadImage';
import {renderInputCounter} from './inputCounter';
import {renderInputHighlight} from './inputHighlight';
import {renderOnOffSwitch} from './onOffSwitch';
import {renderPagination} from './pagination';
import {renderBlockParameters} from './blockParameters';
import {renderNestedSortables} from './sortable';
import {renderMenuItems} from './menuItems';
import {renderSelects} from './selects';

const table = document.getElementById("table");
const form = document.getElementById("form");

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let storeButton = document.getElementById("store-button");
    let createButton = document.getElementById("create-button");

    if(createButton){

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
    }

    if(storeButton){

        storeButton.addEventListener("click", (event) => {
    
            forms.forEach(form => { 
                
                let data = new FormData(form);
                let url = form.action;
    
                if( ckeditors != 'null'){
    
                    Object.entries(ckeditors).forEach(([key, value]) => {
                        data.append(key, value.getData());
                    });
                }
    
                let sendPostRequest = async () => {
    
                    startWait();
        
                    try {
                        await axios.post(url, data).then(response => {
    
                            if(response.data.id){
                                form.id.value = response.data.id;
                            }
                            
                            table.innerHTML = response.data.table;
                            form.innerHTML = response.data.form;
    
                            stopWait();
                            showMessage('success', response.data.message);
                            renderTable();
                            renderForm();
                        });
                        
                    } catch (error) {
        
                        stopWait();
    
                        if(error.response.status == '422'){
        
                            let errors = error.response.data.errors;      
                            let errorMessage = '';
        
                            Object.keys(errors).forEach(function(key) {
                                errorMessage += '<li>' + errors[key] + '</li>';
                            })
            
                            showMessage('validation', errorMessage);
                        }
    
                        if(error.response.status == '500'){
                        
                        }
                    }
                };
        
                sendPostRequest();
            });
        });
    }
 
    renderCkeditor();
    renderTabs();
    renderLocaleTabs();
    renderUploadImage();
    renderInputCounter();
    renderBlockParameters();
    renderInputHighlight();
    renderOnOffSwitch();
    renderLocaleTags();
    renderLocaleSeo();
    renderGoogleBot();
    renderSitemap();
    renderNestedSortables();
    renderMenuItems();
    renderSelects();
};

export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let modalDelete = document.getElementById('modal-delete');
    let deleteConfirm = document.getElementById('delete-confirm');
    let deleteCancel = document.getElementById('delete-cancel');

    if(editButtons){

        editButtons.forEach(editButton => {

            editButton.addEventListener("click", () => {
    
                let url = editButton.dataset.url;
    
                let sendEditRequest = async () => {
    
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
            });
        });
    }

    if(deleteButtons){

        deleteButtons.forEach(deleteButton => {

            deleteButton.addEventListener("click", () => {
    
                let url = deleteButton.dataset.url;
                deleteConfirm.dataset.url = url;
                modalDelete.classList.add('modal-active');
                startOverlay();
            });
        });
    
        deleteCancel.addEventListener("click", () => {
            modalDelete.classList.remove('modal-active');
            stopWait();
        });
    
        deleteConfirm.addEventListener("click", () => {
    
            let url = deleteConfirm.dataset.url;
        
            let sendDeleteRequest = async () => {
    
                try {
                    await axios.delete(url).then(response => {
                        
                        if(response.data.table){
                            table.innerHTML = response.data.table;
                        }

                        form.innerHTML = response.data.form;
                        modalDelete.classList.remove('modal-active');
                        renderTable();
                        renderForm();
    
                        stopWait();
                        showMessage('success', response.data.message);
                    });
                    
                } catch (error) {
                    stopWait();
                    console.error(error);
                }
            };
    
            sendDeleteRequest();
        });    
    }
   
    renderPagination();
};

renderForm();
renderTable();


