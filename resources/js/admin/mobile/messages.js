const closeButtons = document.querySelectorAll('.message-close');
const messagesContainer = document.getElementById('messages-container');
const messages = document.querySelectorAll('.message');

export let showMessage = (state, messageText) => {

    messages.forEach(message => {

        if(message.classList.contains(state)){

            let successMessage = document.getElementById('message-description-'+ state);

            messagesContainer.classList.add('show');
            message.classList.add('message-active');
            successMessage.innerHTML = messageText;

            setTimeout(function(){ 
                messagesContainer.classList.remove('show');
                message.classList.remove('message-active');
            }, 7000);
        };
    });
}

closeButtons.forEach(closeButton => {

    closeButton.addEventListener("click", () => {

        messagesContainer.classList.remove('show');
        
        let messagesActives = document.querySelectorAll('.message-active');

        messagesActives.forEach(messageActive => {
            messageActive.classList.remove('message-active');
        });
    });
});
