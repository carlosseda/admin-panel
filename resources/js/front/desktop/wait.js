const spinner = document.getElementById('spinner');
const overlay = document.getElementById('overlay');
const partials = document.querySelectorAll('.partial');

export let startWait = () => {
    spinner.classList.add('spinner-active');
    overlay.classList.add('overlay-active');
}

export let stopWait = () => {
    spinner.classList.remove('spinner-active');
    overlay.classList.remove('overlay-active');
}

export let startOverlay = () => {
    
    partials.forEach(partial => {

        partial.classList.add('partial-blur');
    });

    overlay.classList.add('overlay-active');

    overlay.addEventListener("click", (e) => {
        
        let modals = document.querySelectorAll('.modal');

        partials.forEach(partial => {
            partial.classList.remove('partial-blur');
        });

        modals.forEach(modal => {
            if(modal.classList.contains('modal-active')){
                modal.classList.remove('modal-active');
            }
        }); 

        overlay.classList.remove('overlay-active');

    })
}

export let stopOverlay = () => {
    overlay.classList.remove('overlay-active');

    partials.forEach(partial => {
        partial.classList.remove('partial-blur');
    });
}