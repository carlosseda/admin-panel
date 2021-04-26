export function trackingScroll(updateMove) {

    let url = "/admin/tracking/scroll";

    let sendTrackingRequest = async () => {

        try {
            await axios.post(url, updateMove).then(response => {
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendTrackingRequest();
}

export function trackingPagination(updateMove) {

    let url = "/admin/tracking/pagination";

    let sendEditRequest = async () => {

        try {
            await axios.post(url, updateMove).then(response => {
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendEditRequest();
}