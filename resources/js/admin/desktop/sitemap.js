import {startWait, stopWait} from './wait';

export let renderSitemap = () => {

    let createSitemap = document.getElementById('create-sitemap');
    let sitemap = document.getElementById('sitemap');


    if(createSitemap){

        createSitemap.addEventListener("click", () => {

            let url = createSitemap.dataset.url;
        
            let sendEditRequest = async () => {
    
                try {
                    await axios.get(url).then(response => {
                        sitemap.value = response.data.sitemap;
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendEditRequest();
        });
    }
}
