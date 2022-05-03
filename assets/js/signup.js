
if(document.querySelector(".form-register")){

    formRegister = document.querySelector(".form-register");

    formRegister.addEventListener("submit", function(e){

        buildForm(e, sendFormSignup);
    });
}


function buildForm(e, sender){

    e.preventDefault();

    form = e.currentTarget;
    formData = new FormData(form);

    sender(formData)
}


function sendFormSignup(form){

    fetch("signup_action.php",{
        method: 'POST',
        body: form
    })
    .then(res => res.json())
    .then(json=>{

        displayMessage(json.type, json.msg);
        
        if(json.type == "success"){  

            setTimeout(()=>{
                window.location.reload();
            },1000)
        }

    }).catch(()=>{
        displayMessage('error', 'Erro ao Enviar os Dados! Tente Novamente.'); 
    })
}


function displayMessage(type, msg, timeHide=false){

    message = document.querySelector(".message");

    message.classList.remove("m-hide");
    message.classList.add("m-show");

    if(type == 'error'){
        message.classList.remove("alert-primary");
        message.classList.add("alert-danger");

    }else if(type == 'success'){
        message.classList.remove("alert-danger");
        message.classList.add("alert-primary");
    }

    message.innerHTML = msg;

    if(timeHide){

        setTimeout(()=>{
            message.classList.remove("m-show");
            message.classList.add("m-hide");
        },timeHide)
    }

}

