const passwordCheckChange = document.querySelector('#Passwordcheck');
const passwordChange = document.querySelector('#Password');
const emailChange = document.querySelector('#Email');
const emailCheckChange = document.querySelector('#Emailcheck');
const formChange = document.querySelector('#FormSignInUp');


document.querySelector('button').disabled = true;

passwordCheckChange.addEventListener('input', ()=> {
    check_password();
});

passwordChange.addEventListener('input', ()=> {
    check_password();
});

emailChange.addEventListener('input', ()=> {
    check_email();

});

emailCheckChange.addEventListener('input', ()=> {
    check_email();

});

formChange.addEventListener('input', ()=> {
    check_fill();
});

function check_fill(){
    let xPseudo = document.querySelector("#Pseudo").value;
    let xPassword = document.querySelector("#Password").value;
    let xPasswordCheck = document.querySelector("#Passwordcheck").value;
    let xEmail = document.querySelector("#Email").value;
    let xEmailCheck = document.querySelector("#Emailcheck").value;

    if (xPseudo.length > 0 && (xPassword === xPasswordCheck && xPassword.length >= 8) && (xEmail === xEmailCheck && xEmail.length > 0)){
        document.querySelector('button').disabled = false;
    } else {
        document.querySelector('button').disabled = true;
    }

}

function check_password(){
    let xPassword = document.querySelector("#Password").value;
    let xPasswordCheck = document.querySelector("#Passwordcheck").value;

    if (xPassword.length < 8){
        document.querySelector("#LabelPassword").innerHTML = "<font color='red' size=0.5em>Mot de passe trop court, 8 caractères minimum !</font><br>";
    } else {
        document.querySelector("#LabelPassword").innerHTML = "";
    }

    if (xPassword !== xPasswordCheck){
        document.querySelector("#LabelPasswordcheck").innerHTML = "<font color='red' size=0.5em>Les mots de passe ne correspondent pas !</font><br>";
    } else {
        document.querySelector("#LabelPasswordcheck").innerHTML = "";
    }
}

function check_email(){
    let xEmail = document.querySelector("#Email").value;
    let xEmailCheck = document.querySelector("#Emailcheck").value;


    if (xEmail !== xEmailCheck){
        document.querySelector("#LabelEmailcheck").innerHTML = "<font color='red' size=1em>L'email ne correspond pas !</font><br>";
    } else {
        document.querySelector("#LabelEmailcheck").innerHTML = "";
    }
}