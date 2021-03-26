const submitBTN = document.querySelector('#btnsignup');

submitBTN.addEventListener('click', ()=> {
    let xPseudo = document.querySelector("#Pseudo");
    let xPassword = document.querySelector("#Password");
    let xPasswordCheck = document.querySelector("#Passwordcheck");
    let xEmail = document.querySelector("#Email");
    let xEmailCheck = document.querySelector("#Emailcheck");

    isInputEmpty(xPseudo);
    isInputEmpty(xPassword);
    isInputEmpty(xPasswordCheck);
    isInputEmpty(xEmail);
    isInputEmpty(xEmailCheck);
});

function isInputEmpty(inputField) {

    if (inputField.value.length === 0){
        inputField.style.backgroundColor = '#FA0505';
    }


}
