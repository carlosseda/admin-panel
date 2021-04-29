import {renderTable} from './crudTable';

export let renderFilterTable = () => {

    let table = document.getElementById("table");
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
            
            let data = new FormData(filterForm);
            let filters = {};
            
            data.forEach(function(value, key){
                filters[key] = value;
            });
            
            let json = JSON.stringify(filters);

            let url = filterForm.action;
    
            let sendPostRequest = async () => {
    
                try {
                    axios.get(url, {
                        params: {
                          filters: json
                        }
                    }).then(response => {
                        table.classList.add('table-hide');
                        table.innerHTML = response.data.table;
                        renderTable();

                        setTimeout(function(){
                            table.classList.remove('table-hide');
                        }, 500)
                        
                        tableFilter.classList.remove('filter-active')
                        applyFilter.classList.remove('button-active');
                        openFilter.classList.add('button-active');
                    });
                    
                } catch (error) {
    
                }
            };
    
            sendPostRequest();
            
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