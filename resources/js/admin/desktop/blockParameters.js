
export let renderBlockParameters = () => {

    let blockParameters = document.querySelectorAll('.block-parameters');

    if(blockParameters){

        blockParameters.forEach( blockParameter => {

            blockParameter.addEventListener("keydown", () => {
    
                let parameters = blockParameter.value.match(/\{.*?\}/g);
    
                blockParameter.dataset.url = blockParameter.value;
                blockParameter.dataset.parameters = parameters ;
            });
    
            blockParameter.addEventListener("keyup", () => {
    
                let parameters = blockParameter.value.match(/\{.*?\}/g);
                let previousParameters =  blockParameter.dataset.parameters;

                if(parameters){
                    var parametersString = parameters.toString();
                }

                if(previousParameters == null && parameters == null){
                    var isSame = true;
                }
                
                if(previousParameters != null && parameters == null){
                    var isSame = false;
                }
            
                if(previousParameters != null && parameters != null){

                    var isSame = (parametersString.length == previousParameters.length) && parameters.every(function(element, index) {

                        return element[index] === previousParameters[index]; 
                    });
                }
            
                if(!isSame){
                    blockParameter.value = blockParameter.dataset.url;
                }
            });
        });
    }
}
