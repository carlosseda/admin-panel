export let showMessage = (state, messageText) => {

    let messagesContainer = document.getElementById('messages-container');
    let messages = document.querySelectorAll('.message');

    messages.forEach(message => {

        if(message.classList.contains(state)){

            let successMessage = document.getElementById('message-description-'+ state);

            messagesContainer.classList.add('show');
            message.classList.add('message-active');
            successMessage.innerHTML = messageText;

            setTimeout(function(){ 
                messagesContainer.classList.remove('show');
                message.classList.remove('message-active');
            }, 5000);
        };
    });
}
