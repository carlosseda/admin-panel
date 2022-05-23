export let renderFilterTable = () => {

    let tableFilter = document.getElementById("table-filter");
    let filterForm = document.getElementById("filter-form");

    if(filterForm != null){

        let openFilter = document.getElementById("open-filter");
        let applyFilter = document.getElementById("apply-filter");
    
        openFilter.addEventListener( 'click', () => {
            openFilter.classList.remove('button-active');
            tableFilter.classList.add('filter-active')
            applyFilter.classList.add('button-active');
        });
        
        applyFilter.addEventListener( 'click', () => {     
            
            let url = new URL(filterForm.action);
            let data = new FormData(filterForm);
            let filters = {};
            
            data.forEach(function(value, key){
                filters[key] = value;
            });
            
            let json = JSON.stringify(filters);
            url.searchParams.set('filters', json);

            console.log(url.href);

            let sendFilterRequest = async () => {

                let response = await fetch(url.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
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
                    
                    tableFilter.classList.remove('filter-active')
                    applyFilter.classList.remove('button-active');
                    openFilter.classList.add('button-active');
                })
                .catch(error =>  {

                    document.dispatchEvent(new CustomEvent('stopWait'));

                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
    
            sendFilterRequest();
            
        });
    }
};

export let hideFilterTable = () => {

    let openFilter = document.getElementById("open-filter");

    openFilter.classList.remove('button-active');
}

export let showFilterTable = () => {

    let openFilter = document.getElementById("open-filter");

    openFilter.classList.add('button-active');
}

renderFilterTable();