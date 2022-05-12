export let renderPagination = () => {

    document.addEventListener("renderTableModules",( event =>{
        renderPagination();
    }));

    let paginationButtons = document.querySelectorAll('.table-pagination-button');

    paginationButtons.forEach(paginationButton => {

        paginationButton.addEventListener("click", () => {

            let url = paginationButton.dataset.pagination;

            let sendPaginationRequest = async () => {

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
                })
                .catch ( error =>  {

                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };

            sendPaginationRequest();
            
        });
    });
}

