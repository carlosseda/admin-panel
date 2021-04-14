const plusButtons = document.querySelectorAll('.faq-plus-button');
const faqElements = document.querySelectorAll(".faq");

plusButtons.forEach(plusButton => { 

    plusButton.addEventListener("click", () => {

        let activeElements = document.querySelectorAll(".active");

        if(plusButton.classList.contains("active")){

            plusButton.classList.remove("active");

            activeElements.forEach(activeElement => {
                activeElement.classList.remove("active");
            });

        }else{

            activeElements.forEach(activeElement => {
                activeElement.classList.remove("active");
            });
            
            plusButton.classList.add("active");

            faqElements.forEach(faqElement => {

                if(faqElement.dataset.content == plusButton.dataset.button){
                    faqElement.classList.add("active"); 
                }else{
                }
            });
        }
    });
    
});

