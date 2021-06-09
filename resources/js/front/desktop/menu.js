import {renderComponents} from './components';
import {sendFingerprintRequest} from './fingerprint';

export let renderMenu = () => {

    let menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(menuItem => { 

        menuItem.addEventListener("click", () => {

            let activeElements = document.querySelectorAll(".selected");
            let url = menuItem.dataset.route;
            let mainContent = document.getElementById('main-content');

            if(!menuItem.classList.contains("active")){

                activeElements.forEach(activeElement => {
                    activeElement.classList.remove("selected");
                });
                
                menuItem.classList.add("selected");

                let sendPageRequest = async () => {

                    try {

                        axios.get(url).then(response => {
                            mainContent.innerHTML = response.data.view;
                            renderComponents();

                            window.history.pushState('', '', url);
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
    
        let sendPageRequest = async () => {
    
            try {
    
                axios.get(url).then(response => {
                    mainContent.innerHTML = response.data.view;
                    renderComponents();
    
                    window.history.pushState(url, 'url', url);
                });
                
            } catch (error) {
    
            }
        };
    
        sendPageRequest();
        
    });
    
}

renderMenu();

