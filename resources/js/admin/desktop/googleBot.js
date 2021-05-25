import {renderTable} from './crudTable';
import {showMessage} from './messages';
import {startWait, stopWait} from './wait';

export let renderGoogleBot = () => {

    let table = document.getElementById("table");
    let pingGoogle = document.getElementById('ping-google');

    if(pingGoogle){

        pingGoogle.addEventListener("click", () => {

            let url = pingGoogle.dataset.url;
        
            let sendEditRequest = async () => {
    
                try {
                    await axios.get(url).then(response => {
                        showMessage('success', response.data.message);
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendEditRequest();
        });
    }
}
