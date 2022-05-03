<?php

require_once("models/TopicLike.php");
require_once("dao/AnswerDaoMysql.php");


class TopicLikeDaoMysql implements TopicLikeDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function getAllLikesFrom($id_user){

        $answerDao = new AnswerDaoMysql($this->pdo);

        $answersList = $answerDao->getAnswersFrom($id_user);

        $answersListIds = [];

        foreach($answersList as $answerItem){
            $answersListIds = $answerItem->id;
        }

        return $answersListIds;

        //$stmt = $this->pdo->prepare("SELECT * FROM topic_likes WHERE")
    }
}