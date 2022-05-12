export let renderLocaleTags = () => {

    let importTags = document.getElementById('import-tags');

    document.addEventListener("renderFormModules",( event =>{
        renderLocaleTags();
    }));

    if(importTags){

        importTags.addEventListener("click", () => {

            let url = importTags.dataset.url;
        
            let sendImportTagsRequest = async () => {

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
    
            sendImportTagsRequest();
        });
    }
}
