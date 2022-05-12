export let renderInputCounter = () => {

    document.addEventListener("renderFormModules",( event =>{
        renderInputCounter();
    }));

    let inputCounters = document.querySelectorAll('.input-counter');
    
    inputCounters.forEach(inputCounter => {
        
        inputCounter.addEventListener('input', (event) => {

            let counterCharacter = inputCounter.parentElement.querySelector('span');
            let limitCharacter = event.currentTarget.getAttribute("maxlength");
    
            if(event.currentTarget.value.length <= limitCharacter){
                counterCharacter.textContent = event.currentTarget.value.length;
            }
        }); 

    });
}

