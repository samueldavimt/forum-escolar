<?php

require_once("models/AnswerLike.php");
require_once("dao/AnswerDaoMysql.php");


class AnswerLikeDaoMysql implements AnswerLikeDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function buildAnswerLike($data){

        $answerLike = new AnswerLike();
        $answerLike->id = $data['id'];
        $answerLike->id_user = $data['id_user'];
        $answerLike->id_answer = $data['id_answer'];
        $answerLike->created_at = $data['created_at'];

        return $answerLike;
    }

    public function getAllLikesFrom($id_user){

        $answerDao = new AnswerDaoMysql($this->pdo);

        $answersList = $answerDao->getAnswersFrom($id_user);

        $answersListIds = [];

        foreach($answersList as $answerItem){
            $answersListIds[] = $answerItem->id;
        }

        $answersListIds = implode(", ",$answersListIds);
        $answerLikes = [];

        if(strlen($answersListIds) < 1){
            return $answerLikes;
        }

        $stmt = $this->pdo->query("SELECT * FROM answer_likes WHERE id_answer IN ($answersListIds)");


        if($stmt->rowCount() > 0){
            $data = $stmt->fetchAll();
            foreach($data as $answerLikeItem){
                $answerLike = $this->buildAnswerLike($answerLikeItem);

                $answerLikes[] = $answerLike;
            }
        }

        return $answerLikes;
    }

    public function getLikesByAnswer($id_answer){

        $stmt = $this->pdo->prepare("SELECT * FROM answer_likes WHERE id_answer=:id_answer");
        $stmt->bindValue(":id_answer",$id_answer);
        $stmt->execute();

        $answerLikes = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $answerLikeItem){
                $answerLike = $this->buildAnswerLike($answerLikeItem);
                $answerLikes[] = $answerLike;   
            }
        }

        return $answerLikes; 
    }

    public function isLiked($id_answer, $id_user){

        $stmt = $this->pdo->prepare("SELECT * FROM answer_likes WHERE id_answer=:id_answer AND id_user=:id_user");
        $stmt->bindValue(":id_answer",$id_answer);
        $stmt->bindValue(":id_user",$id_user);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }

        return false; 
    }
}