<?php

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Filter.php");
require_once("models/Validate.php");
require_once("models/Message.php");

$auth = new Auth($pdo, $base);
$filter = new Filter();
$newMessage = new Message();

$userInfo = $auth->checkToken(true);

$category = $filter->input($_POST['category']);
$content = $filter->input($_POST['content']);

if($category && $content){

    $validate = new Validate($pdo);

    if(!$validate->categoryExists($category)){
        $newMessage->return("error", "Preencha os Campos Corretamente!");
    }

    $newTopic = new Topic();
    $newTopic->id_user =  $userInfo->id;
    $newTopic->category = $category;
    $newTopic->body = $content;
    $newTopic->state = "Aberto";
    $newTopic->created_at = date("Y-m-d H:i:s");

    $topicDao = new TopicDaoMysql($pdo);
    $insertResult = $topicDao->insert($newTopic);

    $currentTopic = $topicDao->findById($insertResult);

    $datesFromTopic = [

        "id_topic"       => $currentTopic->id,
        "content_topic"  => $currentTopic->body,
        "state_topic"    => $currentTopic->state,
        "count_answers"  => count($currentTopic->answers),
        "category_topic" => $currentTopic->category,
        "answer_topic"   => $base . "topic.php?id=" . $currentTopic->id,
        
        "user_id"      => $currentTopic->id_user,
        "user_avatar"  => $base . "media/avatars/" . $currentTopic->user->avatar,
        "user_name"    => $currentTopic->user->shortName(),
        "user_grade"   => $currentTopic->user->grade,
        "user_profile" => $base . "profile.php?id=" . $currentTopic->user->id
    ];

    $newMessage->return("success", "Novo Tópico Criado!", $datesFromTopic);



}else{
    $newMessage->return("error", "Preencha todos os Campos!");

}