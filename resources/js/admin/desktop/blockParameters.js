
export let renderBlockParameters = () => {

    document.addEventListener("renderFormModules",( event =>{
        renderBlockParameters();
    }));

    let blockParameters = document.querySelectorAll('.block-parameters');

    if(blockParameters){

        blockParameters.forEach( blockParameter => {
        
            let originalInput = blockParameter.value.match(/\{.*?\}/g)

            if (originalInput){

                blockParameter.addEventListener("keydown", () =>{
                    
                    let setInput = blockParameter.value;

                    blockParameter.addEventListener("keyup", () =>{
                        
                        let finalInput = blockParameter.value.match(/\{.*?\}/g)
        
                        if (finalInput){

                            if(originalInput.toString() != finalInput.toString()){
                                blockParameter.value = setInput;
                            }

                        }else{
                            blockParameter.value = setInput;
                        }
                        
                        setInput = blockParameter.value
                    })
                });   
            }  
        });
    }
}
