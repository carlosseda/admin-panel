export let renderForm = () => {

    let forms = document.querySelectorAll(".form");
    let sendButton = document.getElementById("send-button");

    if(sendButton){

        sendButton.addEventListener("click", (event) => {

            event.preventDefault();
    
            forms.forEach(form => { 
                
                let data = new FormData(form);
                let url = form.action;
    
                let sendPostRequest = async () => {
            
                    try {
                        await axios.post(url, data).then(response => {
                                
                            if(document.getElementById("error-container").classList.contains('active')){
                                document.getElementById("error-container").classList.remove('active');
                            }
                        
                            document.getElementById("success-container").classList.add('active');
                            document.getElementById("success-message").innerHTML = response.data.message;
                            form.reset();

                            window.history.pushState('', '', url);
                        });
                        
                    } catch (error) {
            
                        if(error.response.status == '422'){
        
                            let errors = error.response.data.errors;      
                            let errorMessage = '';
        
                            Object.keys(errors).forEach(function(key) {
                                errorMessage += '<li>' + errors[key] + '</li>';
                            })
            
                            document.getElementById("error-container").classList.add('active');
                            document.getElementById("errors").innerHTML = errorMessage;
                        }
    
                        if(error.response.status == '500'){
                        
                        }
                    }
                };
        
                sendPostRequest();
            });
        });
    }
}

renderForm();