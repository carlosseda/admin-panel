import {renderTable} from './crudTable';

const table = document.getElementById("table-container");
const tableFilter = document.getElementById("table-filter");
const filterForm = document.getElementById("filter-form");

export let renderFilterTable = () => {

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
            let url = filterForm.action;
    
            let sendPostRequest = async () => {
    
                try {
                    await axios.post(url, data).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
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