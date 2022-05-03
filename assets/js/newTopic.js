if(document.querySelector(".form-create-topic")){

    formCreateTopic = document.querySelector(".form-create-topic");

    formCreateTopic.addEventListener("submit",function(e){
        buildForm(e, sendFormTopic);
    })
}

function sendFormTopic(form){
  
    fetch("topic_action.php",{
        method: "POST",
        body: form
    })
    .then(res => res.json())
    .then((json)=>{

        console.log(json);
        displayMessage(json.type, json.msg, 2000);
        
        if(json.type != "error"){
            insertNewTopic(json.data)
        }
    })
}

function insertNewTopic(info){

    containerTopic = document.querySelector(".topics");

    info.content_topic = info.content_topic.replaceAll('&#13;', "<br>");
    
    topicItem = document.querySelector(".topic-item-preview").cloneNode(true);
    
    topicItem.querySelector(".user-avatar").style = `background-image: url('${info.user_avatar}')`;

    topicItem.querySelector(".username").innerHTML = info.user_name;
    topicItem.querySelector(".username").href = info.user_profile;

    topicItem.querySelector(".short-info").innerHTML = `${info.category_topic} - ${info.user_grade}ºano`;

    topicItem.querySelector(".state").innerHTML = info.state_topic;

    topicItem.querySelector(".count-answers span").innerHTML = info.count_answers;

    topicItem.querySelector(".topic-subject").innerHTML = info.content_topic;

    topicItem.querySelector(".answer-topic a").href = info.answer_topic;

    containerTopic.prepend(topicItem)

}
