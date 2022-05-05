
if(document.querySelector(".delete-ok")){
    document.querySelector(".delete-ok").addEventListener("click", confirmDeletion)
}

if(document.querySelector(".answer-item")){

    document.querySelectorAll(".answer-item").forEach(answerItem =>{

        buttonDeleteAnswer = answerItem.querySelector("#button-delete-answer");
        
        if(buttonDeleteAnswer){
            buttonDeleteAnswer.addEventListener("click",deleteAnswer);
        }
    })
}

function deleteAnswer(e){

    confirmDeletion = document.querySelector("#modalDeleteAnswer");

    buttonDeleteAnswer = e.currentTarget;
    answerId = buttonDeleteAnswer.closest(".answer-item").dataset.id;
    confirmDeletion.dataset.id = answerId;

}

function confirmDeletion(e){

    idAnswer = e.currentTarget.closest("#modalDeleteAnswer").dataset.id;
    form = new FormData();
    form.append("id_answer", idAnswer);

    fetch("answer_delete_action.php",{
        method: "POST",
        body: form
    }).then(()=>{
        window.location.reload();
    })

}


if(document.querySelector("#send-answer")){

    document.querySelector("#send-answer").addEventListener("click",function(e){

        buildFormAnswer(e)
    })
}


function buildFormAnswer(e){

    sendButton = e.currentTarget;
    topicItem = sendButton.closest(".topic-item");

    contentAnswer = topicItem.querySelector("#content-answer").value;
    topicId = topicItem.dataset.id;

    formData = new FormData();
    formData.append("id_topic", topicId);
    formData.append("content_answer", contentAnswer);

    sendFormAnswer(formData);

}

function sendFormAnswer(form){

    fetch("answer_action.php",{

        method: "POST",
        body: form
    })
    .then(res => res.json())
    .then(function(json){

        if(json.type != "error"){
            window.location.reload();
        }
    })

    
}
