<?php

require_once("config/globals.php");
require_once("dao/AnswerDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");
require_once("dao/AnswerLikeDaoMysql.php");
require_once("models/Filter.php");
require_once("models/Message.php");

$auth = new Auth($pdo, $base);
$answerDao = new AnswerDaoMysql($pdo);
$answerLikeDao = new AnswerLikeDaoMysql($pdo);

$filter = new Filter();
$message = new Message();

$userInfo = $auth->checkToken(true);

$answerId = $filter->id($_POST['id_answer']);

$currentAnswer = $answerDao->findById($answerId);

if($currentAnswer){
    $answerLike = new AnswerLike();
    $answerLike->id_user = $userInfo->id;
    $answerLike->id_answer = $answerId;
    $answerLike->created_at = date("Y-m-d H:i:s");

    $answerLikeDao->likeToggle($answerLike);

}