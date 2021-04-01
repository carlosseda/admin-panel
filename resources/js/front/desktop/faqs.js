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


// const observer = new MutationObserver((mutations) => { 

//     mutations.forEach((mutation) => {

//         if (mutation.attributeName === 'class') {

//             const currentState = mutation.target.classList.contains('active');
            
//             if (prevState !== currentState) {
//                 prevState = currentState;
//                 console.log(`'is-busy' class ${currentState ? 'added' : 'removed'}`);
//             }
//         }
//     });
// });

// var config = { 
//     attributes: true,
//     attributeOldValue: true,
//     attributeFilter: ["class"]
// }

// observer.observe(element, config);
