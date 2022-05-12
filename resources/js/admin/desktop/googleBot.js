export let renderGoogleBot = () => {

    document.addEventListener("renderFormModules",( event =>{
        renderGoogleBot();
    }));

    let table = document.getElementById("table");
    let pingGoogle = document.getElementById('ping-google');

    if(pingGoogle){

        pingGoogle.addEventListener("click", () => {

            let url = pingGoogle.dataset.url;
        
            let sendEditRequest = async () => {
    
                let response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    method: 'GET', 
                }) .then(response => {
                                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {
                    document.dispatchEvent(new CustomEvent('message', {
                        detail: {
                            message: json.message,
                            type: 'success'
                        }
                    }));
                })
                .catch(error =>  {
    
                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
    
            sendEditRequest();
        });
    }
}
