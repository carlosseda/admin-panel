export let renderOnOffSwitch = () => {

    document.addEventListener("renderFormModules",( event =>{
        renderOnOffSwitch();
    }), {once: true});

    let onOffSwitch = document.getElementById('onoffswitch');

    if(onOffSwitch ){

        onOffSwitch.addEventListener("click", () => {

            if(onOffSwitch.value == "true"){
                onOffSwitch.value = "false";
            }else{
                onOffSwitch.value = "true";
            }
        });
    }
}