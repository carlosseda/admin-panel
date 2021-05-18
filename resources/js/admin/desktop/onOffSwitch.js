export let renderOnOffSwitch = () => {

    let onOffSwitch = document.getElementById('onoffswitch');

    onOffSwitch.addEventListener("click", () => {

        if(onOffSwitch.value == "true"){
            onOffSwitch.value = "false";
        }else{
            onOffSwitch.value = "true";
        }
    });

}