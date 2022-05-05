<?php

require_once("dao/AnswerDaoMysql.php");
require_once("config/globals.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Filter.php");

$auth = new Auth($pdo, $base);
$topicDao = new TopicDaoMysql($pdo);
$answerDao = new AnswerDaoMysql($pdo);
$filter = new Filter();

$userInfo = $auth->checkToken(true);

$topicId = $filter->id($_POST['topic_id']);

$currentTopic = $topicDao->findById($topicId);

if($currentTopic){

    if($userInfo->id == $currentTopic->id_user){
        
        $topicDao->delete($topicId);
        $answerDao->deleteAllAnswersByTopic($topicId);
    }
}