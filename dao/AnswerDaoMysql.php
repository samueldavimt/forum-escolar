<?php

require_once("models/Answer.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/AnswerLikeDaoMysql.php");
require_once("models/Auth.php");

class AnswerDaoMysql implements AnswerDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function buildAnswer($data){

        $answer = new Answer();

        $answer->id = $data['id'];
        $answer->id_user = $data['id_user'];
        $answer->id_topic = $data['id_topic'];
        $answer->body = $data['body'];
        $answer->created_at = $data['created_at'];

        $userDao = new UserDaoMysql($this->pdo);
        $answerLikeDao = new AnswerLikeDaoMysql($this->pdo);
        $auth = new Auth($this->pdo, false);
        
        $currentUser = $auth->checkToken(false);

        $answer->user = $userDao->findById($answer->id_user);
        $answer->countLikes = count($answerLikeDao->getLikesByAnswer($answer->id));
        $answer->isLiked = $answerLikeDao->isLiked($answer->id, $currentUser->id);
        
        if($answer->id_user == $currentUser->id){
            $answer->mine = true;
        }else{
            $answer->mine = false;
        }


        return $answer;
    }

    public function getAnswersFrom($id_user){

        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE id_user=:id_user");
        $stmt->bindValue(":id_user",$id_user);
        $stmt->execute();

        $answers = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $answerItem){
                $answer = $this->buildAnswer($answerItem);
                $answer->mine = true;
                $answers[] = $answer;   
            }
        }

        return $answers; 
    }

    public function getAnswersByTopic($id_topic){

        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE id_topic=:id_topic ORDER BY created_at DESC");
        $stmt->bindValue(":id_topic",$id_topic);
        $stmt->execute();

        $answers = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $answerItem){

                $answer = $this->buildAnswer($answerItem);
                $answers[] = $answer;   
            }
        }

        return $answers; 
    }

    public function insert(Answer $answer){

        $stmt = $this->pdo->prepare("INSERT INTO answers
        (id_user, id_topic, body, created_at) 
        VALUES 
        (:id_user, :id_topic, :body, :created_at)");

        $stmt->bindValue(":id_user",$answer->id_user);
        $stmt->bindValue(":id_topic",$answer->id_topic);
        $stmt->bindValue(":body",$answer->body);
        $stmt->bindValue(":created_at",$answer->created_at);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function findById($id){

        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE id=:id LIMIT 1");
        $stmt->bindValue(":id",$id);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $answer = $this->buildAnswer($data);
            return $answer;

        }else{
            return false;
        }
    }

    public function delete($id){

        $stmt = $this->pdo->prepare("DELETE FROM answers WHERE id=:id");
        $stmt->bindValue(":id",$id);
        $stmt->execute();
    }
    

}