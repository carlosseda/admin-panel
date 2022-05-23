import 'clientjs';

export let renderFingerprint = () => {

    let client = new ClientJS();
    let data = new FormData();
    let fingerprint = {};
    
    fingerprint['_token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fingerprint['fingerprint_code'] = client.getFingerprint();
    fingerprint['browser'] = client.getBrowser();
    fingerprint['browser_version'] = client.getBrowserMajorVersion();
    fingerprint['OS']= client.getOS();
    fingerprint['resolution'] = client.getCurrentResolution();
    fingerprint['current_url'] = window.location.pathname;

    for ( var key in fingerprint ) {
        data.append(key, fingerprint[key]);
    }

    let sendPostRequest = async () => {
        try {
            await axios.post('/fingerprint', data).then(response => {
            });
            
        } catch (error) {
    
        }
        // let response = await fetch( '/fingerprint' , {
        //     headers: {
        //         'Accept': 'application/json',
        //         'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        //     },
        //     method: 'POST',
        //     body: data
        // })
        // .then(response => {
        
        //     if (!response.ok) throw response;

        //     return response.json();
        // })
        // .then(json => {
        //     console.log(json)
        // })
        // .catch ( error =>  {
        //     if(error.status == '500'){
        //         console.log(error);
        //     };
        // });
    }

    sendPostRequest();
};

