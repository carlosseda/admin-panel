export let renderSelects = () =>{

    let selectsRelated = document.querySelectorAll('.primary-select-related');
    let selectsDisplay = document.querySelectorAll('.select-display');
    
    selectsDisplay.forEach(selectDisplay => {
    
        selectDisplay.addEventListener("change", () => {
    
            let selectDisplayOptions = document.querySelectorAll('.select-display-option');
    
            selectDisplayOptions.forEach(selectDisplayOption => {
            
                if(selectDisplayOption.dataset.option == selectDisplay.value){
                    selectDisplayOption.classList.add('visible');
                }else{
                    selectDisplayOption.classList.remove('visible');
                }
            });
        });
    });
    
    selectsRelated.forEach(selectRelated => {
    
        selectRelated.addEventListener("change", () => {
    
            let secondaryRelated = document.querySelector('.secondary-select-related');
            let secondaryRelatedOptions = document.querySelectorAll('.secondary-select-related option');
    
            secondaryRelatedOptions.forEach(secondaryRelatedOption => {
                
                if(selectRelated.value == secondaryRelatedOption.dataset.related){
                    secondaryRelated.closest('.select-related').classList.add('visible');
                    secondaryRelatedOption.classList.remove('hidden');
                }else{
                    secondaryRelated.closest('.select-related').classList.remove('visible');
                    secondaryRelatedOption.classList.add('hidden');
                }
            });
        });
    });
}



// $(document).on('change', '.primary-select-related', function(){
    
//     var optionId =  $(this).val();

//     $('.select-related').removeClass('visible');
//     $(".secondary-select-related").val(" ");
//     $('.secondary-select-related').prop("disabled", false); 
//     $('.secondary-select-related option').addClass('hidden');
//     $('.primary-select-related option[value="' + optionId + '"]').prop('selected', true);

//     var matching = $('.secondary-select-related option').filter(function(){
//         return $(this).data('related') == optionId;
//     });

//     if(matching.length > 0){
//         $(matching).removeClass('hidden'); 
//         $('.select-related').addClass('visible');
//     }
// });

// // select_display

// $(document).on('change', '.select-display', function(){

//     $('.select-display-option').removeClass('visible');
//     $('.select-display-option :input').val('');
//     $('.select-display-option').prop("disabled", true);

//     var select = $('.select-display-option#' + $(this).children(":selected").attr("id"));

//     select.addClass('visible');
//     select.find('.select-option').prop("disabled", false);
// });
// 
