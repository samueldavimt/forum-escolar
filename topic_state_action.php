<?php


require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");
require_once("models/Filter.php");
require_once("models/Validate.php");
require_once("models/Message.php");


$auth = new Auth($pdo, $base);
$topicDao = new TopicDaoMysql($pdo);
$filter = new Filter();
$newMessage = new Message();

$userInfo = $auth->checkToken(true);

$topicId = $filter->id($_POST['topic_id']);

$currentTopic = $topicDao->findById($topicId);

if($currentTopic){

    if($userInfo->id == $currentTopic->id_user){
        
        if($currentTopic->state == "Aberto"){
            $topicDao->updateState($topicId, "Concluído");
        }else{
            $topicDao->updateState($topicId, "Aberto");
        }
    }
}