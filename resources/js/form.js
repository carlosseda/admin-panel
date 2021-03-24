const forms = document.querySelectorAll(".admin-form");
const labels = document.getElementsByTagName('label');
const inputs = document.querySelectorAll('.input')
const sendButton = document.getElementById("send-button");

inputs.forEach(input => {

    input.addEventListener('focusin', () => {

        for( var i = 0; i < labels.length; i++ ) {
            if (labels[i].htmlFor == input.name){
                labels[i].classList.add("active");
            }
        }
    });

    input.addEventListener('blur', () => {

        for( var i = 0; i < labels.length; i++ ) {
            labels[i].classList.remove("active");
        }
    });
});

sendButton.addEventListener("click", () => {

    forms.forEach(form => { 
        
        let data = new FormData(document.getElementById(form.id));
        let url = form.action;

        let sendPostRequest = async () => {

            try {
                let response = await axios.post(url, data).then(response => {
                    console.log(response.data.form)
                    console.log('2');
                });

                console.log('3');
                 
            } catch (err) {
                console.error(err);
            }
        };

        sendPostRequest();

        console.log('1');
    });
});