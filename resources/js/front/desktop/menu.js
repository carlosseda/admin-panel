import {renderComponents} from './components';
import {sendFingerprintRequest} from './fingerprint';

export let renderMenu = () => {

    let menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(menuItem => { 

        menuItem.addEventListener("click", () => {

            let activeElements = document.querySelectorAll(".menu-item-selected");
            let url = menuItem.dataset.route;
            let mainContent = document.getElementById('main-content');

            if(!menuItem.classList.contains("menu-item-selected")){

                activeElements.forEach(activeElement => {
                    activeElement.classList.remove("menu-item-selected");
                });
                
                menuItem.classList.add("menu-item-selected");

                let sendPageRequest = async () => {

                    try {

                        axios.get(url).then(response => {
                            window.history.pushState('', '', url);
                            mainContent.innerHTML = response.data.view;
                            renderComponents();
                        });
                        
                    } catch (error) {
            
                    }
                };
        
                sendPageRequest();
            }
        });
    });

    window.addEventListener('popstate', event => {

        let mainContent = document.getElementById('main-content');
        let url = event.state;
        let menuItems = document.querySelectorAll(".menu-item");
    
        menuItems.forEach(menuItem => {
    
            menuItem.classList.remove("menu-item-selected");
    
            if(window.location.href == new URL(menuItem.dataset.route, window.location.origin)){
                menuItem.classList.add("menu-item-selected");
            }
        });
    
        let sendPageRequest = async () => {
    
            try {
    
                axios.get(url).then(response => {
                    mainContent.innerHTML = response.data.view;
                    renderComponents();    
                });
                
            } catch (error) {
    
            }
        };
    
        sendPageRequest();
        
    });
    
}

renderMenu();

