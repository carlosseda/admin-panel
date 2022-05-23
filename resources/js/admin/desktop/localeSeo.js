export let renderLocaleSeo = () => {

    let importSeo = document.getElementById('import-seo');

    document.addEventListener("renderFormModules",( event =>{
        renderLocaleSeo();
    }), {once: true});

    if(importSeo){

        importSeo.addEventListener("click", () => {

            let url = importSeo.dataset.url;
        
            let sendEditRequest = async () => {

                let response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'GET',
                })
                .then(response => {
                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                    document.dispatchEvent(new CustomEvent('loadTable', {
                        detail: {
                            table: json.table,
                        }
                    }));

                    document.dispatchEvent(new CustomEvent('renderTableModules'));
                    document.dispatchEvent(new CustomEvent('stopWait'));

                    document.dispatchEvent(new CustomEvent('message', {
                        detail: {
                            message: json.message,
                            type: 'success'
                        }
                    }));
                })
                .catch ( error =>  {

                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
    
            sendEditRequest();
        });
    }
}
