<?php

require_once("config/globals.php");
require_once("dao/AnswerDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");
require_once("models/Filter.php");

$auth = new Auth($pdo, $base);
$answerDao = new AnswerDaoMysql($pdo);
$filter = new Filter();

$userInfo = $auth->checkToken(true);

$answerId = $filter->id($_POST['id_answer']);

$currentAnswer = $answerDao->findById($answerId);

if($currentAnswer){

    if($userInfo->id == $currentAnswer->id_user){
        
        $answerDao->delete($answerId);
    }
}