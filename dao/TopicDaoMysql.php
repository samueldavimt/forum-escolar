<?php

require_once("models/Topic.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/AnswerDaoMysql.php");

class TopicDaoMysql implements TopicDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function buildTopic($data){

        $topic = new Topic();

        $topic->id = $data['id'];
        $topic->id_user = $data['id_user'];
        $topic->category = $data['category'];
        $topic->body = $data['body'];
        $topic->state = $data['state'];
        $topic->created_at = $data['created_at'];

        $userDao = new UserDaoMysql($this->pdo);
        $answerDao = new AnswerDaoMysql($this->pdo);

        $topic->user = $userDao->findById($topic->id_user);
        $topic->answers = $answerDao->getAnswersByTopic($topic->id);


        return $topic;
    }

    public function getTopicsFrom($id_user){

        $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE id_user=:id_user ORDER BY created_at DESC");
        $stmt->bindValue(":id_user",$id_user);
        $stmt->execute();

        $topics = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $topicItem){

                $topic = $this->buildTopic($topicItem);
                $topics[] = $topic;   
            }
        }

        return $topics; 
    }

    public function getTopicsHome(){

        $stmt = $this->pdo->prepare("SELECT * FROM topics ORDER BY created_at DESC");
        $stmt->execute();

        $topics = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $topicItem){

                $topic = $this->buildTopic($topicItem);
                $topics[] = $topic;   
            }
        }

        return $topics;
    }

    public function findById($id){

        $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE id=:id LIMIT 1");
        $stmt->bindValue(":id",$id);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $topic = $this->buildTopic($data);
            return $topic;

        }else{
            return false;
        }
    }

    public function insert(Topic $topic){

        $stmt = $this->pdo->prepare("INSERT INTO topics (id_user, category, body, state, created_at) VALUES (:id_user, :category, :body, :state,:created_at)");

        $stmt->bindValue(":id_user",$topic->id_user);
        $stmt->bindValue(":category",$topic->category);
        $stmt->bindValue(":body",$topic->body);
        $stmt->bindValue(":state",$topic->state);
        $stmt->bindValue(":created_at",$topic->created_at);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }


}