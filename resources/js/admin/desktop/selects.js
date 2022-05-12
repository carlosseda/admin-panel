export let renderSelects = () =>{

    document.addEventListener("renderFormModules",( event =>{
        renderSelects();
    }));

    let selectsRelated = document.querySelectorAll('.primary-select-related');
    let selectsDisplay = document.querySelectorAll('.select-display');
    
    selectsDisplay.forEach(selectDisplay => {
    
        selectDisplay.addEventListener("change", () => {
    
            let selectDisplayOptions = document.querySelectorAll('.select-display-option');
    
            selectDisplayOptions.forEach(selectDisplayOption => {
            
                if(selectDisplayOption.dataset.option == selectDisplay.value){
                    selectDisplayOption.classList.add('visible');
                }else{
                    selectDisplayOption.classList.remove('visible');
                }
            });
        });
    });
    
    selectsRelated.forEach(selectRelated => {
    
        selectRelated.addEventListener("change", () => {
    
            let secondaryRelated = document.querySelector('.secondary-select-related');
            let secondaryRelatedOptions = document.querySelectorAll('.secondary-select-related option');
    
            secondaryRelatedOptions.forEach(secondaryRelatedOption => {
                
                if(selectRelated.value == secondaryRelatedOption.dataset.related){
                    secondaryRelated.closest('.select-related').classList.add('visible');
                    secondaryRelatedOption.classList.remove('hidden');
                }else{
                    secondaryRelated.closest('.select-related').classList.remove('visible');
                    secondaryRelatedOption.classList.add('hidden');
                }
            });
        });
    });
}
