const spinner = document.getElementById('spinner');
const overlay = document.getElementById('overlay');

export let startWait = () => {
    spinner.classList.add('spinner-active');
    overlay.classList.add('overlay-active');
}

export let stopWait = () => {
    spinner.classList.remove('spinner-active');
    overlay.classList.remove('overlay-active');
}