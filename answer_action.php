<?php

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("dao/AnswerDaoMysql.php");
require_once("models/Filter.php");
require_once("models/Validate.php");
require_once("models/Message.php");

$auth = new Auth($pdo, $base);
$filter = new Filter();
$newMessage = new Message();

$userInfo = $auth->checkToken(true);

$topicId = $filter->id($_POST['id_topic']);
$contentAnswer = $filter->input($_POST['content_answer']);

if($topicId && $contentAnswer){

    $validate = new Validate($pdo);

    $validateLength = $validate->lenghtLimit([$contentAnswer],800);

    if(!$validateLength){
        $newMessage->return("error", "Limite de Caracteres Atingido!");
    }

    $answerDao = new AnswerDaoMysql($pdo);
    $newAnswer = new Answer();

    $newAnswer->id_user = $userInfo->id;
    $newAnswer->id_topic = $topicId;
    $newAnswer->body = $contentAnswer;
    $newAnswer->created_at = date("Y-m-d H:i:s");

    $resultInsert = $answerDao->insert($newAnswer);
    $newMessage->return("success", "Resposta Postada!");
    
}else{

    $newMessage->return("error", "Preencha os Campos!");
}
