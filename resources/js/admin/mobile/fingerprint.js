import 'clientjs';

const client = new ClientJS();

export function getFingerPrint ()  {
    
    let fingerprint = {};
    fingerprint['_token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fingerprint['fingerprint_code'] = client.getFingerprint();
    fingerprint['browser'] = client.getBrowser();
    fingerprint['browser_version'] = client.getBrowserMajorVersion();
    fingerprint['OS']= client.getOS();
    fingerprint['resolution'] = client.getCurrentResolution();
    fingerprint['current_url'] = window.location.pathname;

    return fingerprint;
}

let sendFingerprintRequest = async () => {
    
    let fingerprint = getFingerPrint();

    let data = new FormData();

    for ( var key in fingerprint ) {
        data.append(key, fingerprint[key]);
    }

    try { 

        await axios.post('/fingerprint', data).then(response => {
            console.log(response);
        });
        
    } catch (error) {

        console.log(error);
    }
};

sendFingerprintRequest();
