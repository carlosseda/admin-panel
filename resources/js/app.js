require('./bootstrap');

const axios = require('axios'); 
const { rest } = require('lodash');
const labels = document.getElementsByTagName('label');
const inputs = document.querySelectorAll('.input')
const sendButton = document.getElementById("send-button");
const titleInput = document.forms['faqs-form'].elements["title"];
const counterCharacter = document.getElementById('counter-character');
const limitCharacter = document.getElementById('limit-character');
const errorMessage = document.getElementById("error-message");

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

    const form = document.getElementById("faqs-form");
    const data = new FormData(form);
    const url = form.action;
    
    const resp = axios.post(url, data);

    // const sendPostRequest = async () => {
    //     try {
    //         const resp = await axios.post(url, data);
    //         console.log(resp.data);
    //     } catch (err) {
    //         console.error(err);
    //     }
    // };
});
