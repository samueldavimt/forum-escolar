if(document.querySelector(".topic-subject")){

    document.querySelectorAll(".topic-subject").forEach(subject =>{
        content = subject.innerHTML;

        if(content.length > 150){

            minSubject = subject.innerHTML.substring(0,150) + "...";
            subject.innerHTML = minSubject;
        }
    })
}

if(document.querySelector('#answer') && document.querySelector(".write-answer")){
    document.querySelector("#answer").addEventListener('click',writeAnswer)
}

function writeAnswer(){

    localWrite = document.querySelector(".write-answer");

    if(localWrite.classList.contains('hide-write-answer')){
        localWrite.classList.remove("hide-write-answer")
        localWrite.classList.add("show-write-answer")

    }else{

        localWrite.classList.add("hide-write-answer")
        localWrite.classList.remove("show-write-answer") 
    }
}


if(document.querySelector("#like-answer")){

    document.querySelectorAll("#like-answer").forEach(buttonLike =>{
        buttonLike.addEventListener("click",likeAnswer)
    })
}


function likeAnswer(e){

    iconLike = e.currentTarget.querySelector('i')
    countLike = e.currentTarget.querySelector(".count-like")

    if(iconLike.classList.contains('bi-heart')){
        iconLike.classList.remove('bi-heart')
        iconLike.classList.add('bi-heart-fill')

        countLike.innerHTML = parseInt(countLike.innerHTML) + 1

    }else{
        iconLike.classList.add('bi-heart')
        iconLike.classList.remove('bi-heart-fill')
        countLike.innerHTML = parseInt(countLike.innerHTML) - 1

    }

    
}


if(document.querySelector("#create-topic")){

    document.querySelector("#create-topic").addEventListener('click',function(){
        
    })
}