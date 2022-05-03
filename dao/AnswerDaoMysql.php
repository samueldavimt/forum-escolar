<?php

require_once("models/Answer.php");

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
                $answers[] = $answer;   
            }
        }

        return $answers; 
    }

    public function getAnswersByTopic($id_topic){

        $stmt = $this->pdo->prepare("SELECT * FROM answers WHERE id_topic=:id_topic");
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
    

}