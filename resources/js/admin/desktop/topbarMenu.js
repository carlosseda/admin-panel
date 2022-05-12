export let renderTopMenu = () => {

    let topbar = document.getElementById('topbar');
    let menuItems = document.querySelectorAll('.menu-item');
    let collapseButton = document.getElementById('topbar-collapse-button');
    let sectionTitle = document.getElementById('section-title');
    
    menuItems.forEach( menuItem => {
    
        menuItem.addEventListener("click", () => {
    
            let url = menuItem.dataset.url;
    
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
    
                    sectionTitle.textContent = menuItem.textContent;
                    collapseButton.classList.remove("active");
                    topbar.classList.remove("active");
    
                    window.history.pushState('', '', url);
    
                    document.dispatchEvent(new CustomEvent('loadForm', {
                        detail: {
                            form: json.form,
                        }
                    }));
    
                    document.dispatchEvent(new CustomEvent('loadTable', {
                        detail: {
                            table: json.table,
                        }
                    }));
    
                    document.dispatchEvent(new CustomEvent('renderTableModules'));
                    document.dispatchEvent(new CustomEvent('renderFormModules'));
                })
                .catch ( error =>  {
    
                    if(error.status == '500'){
                        console.log(error);
                    };
                });
            };
    
            sendEditRequest();
        });
    });
    
    collapseButton.addEventListener("click", () => {
    
        collapseButton.classList.toggle("active");
        topbar.classList.toggle("active");
    });
}

