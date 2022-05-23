export let renderWait = () => {

    let spinner = document.getElementById('spinner');
    let overlay = document.getElementById('overlay');

    document.addEventListener("startWait",( event =>{
        spinner.classList.add('spinner-active');
        overlay.classList.add('overlay-active');
    }));

    document.addEventListener("stopWait",( event =>{
        spinner.classList.remove('spinner-active');
        overlay.classList.remove('overlay-active');
    }));

    document.addEventListener("startOverlay",( event =>{
        overlay.classList.add('overlay-active');
    }));

    document.addEventListener("stopOverlay",( event =>{
        overlay.classList.remove('overlay-active');
    }));

    overlay.addEventListener("click", (e) => {
        
        let modals = document.querySelectorAll('.modal');

        modals.forEach(modal => {
            if(modal.classList.contains('modal-active')){
                modal.classList.remove('modal-active');
            }
        }); 

        overlay.classList.remove('overlay-active');
    })
}
