<?php

require_once("models/Topic.php");
require_once("models/Auth.php");
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
        $auth = new Auth($this->pdo, false);

        $currentUser = $auth->checkToken(false);

        $topic->user = $userDao->findById($topic->id_user);
        $topic->answers = $answerDao->getAnswersByTopic($topic->id);

        if($currentUser->id == $topic->id_user){
            $topic->mine = true;
        }else{
            $topic->mine = false;
        }


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

    public function getTopicsHome($page=1){

        $perPage = 5;
        $pageOffset = 0;

        if(is_numeric($page)){
            $pageOffset = ceil(($page - 1) * $perPage);
        }
       
        if(!isset($pageOffset) || $pageOffset < 0){
            $pageOffset = 0;
        }

        $stmt = $this->pdo->query("SELECT * FROM topics ORDER BY created_at DESC LIMIT $pageOffset, $perPage");

        $topicsInfo = [];
        $topicsInfo['topics'] = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $topicItem){

                $topic = $this->buildTopic($topicItem);
                $topicsInfo['topics'][] = $topic;   
            }
        }

        $numPages = $this->CountAllTopics($perPage);
        $topicsInfo['pages'] = $numPages;

        return $topicsInfo;
    }

    public function CountAllTopics($perPage, $search=false){

        if($search){
            $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE body LIKE :search");
            $stmt->bindValue(":search", "%" . $search . "%");
        }else{
            $stmt = $this->pdo->prepare("SELECT * FROM topics");
        }
        $stmt->execute();

        $allTopics = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        $numPages = ceil($allTopics / $perPage);
        return $numPages;
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

    public function updateState($topic_id, $state){

        $stmt = $this->pdo->prepare("UPDATE topics SET state=:state WHERE id=:id");
        $stmt->bindValue(":state",$state);
        $stmt->bindValue(":id",$topic_id);
        $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->pdo->prepare("DELETE FROM topics WHERE id=:id");

        $stmt->bindValue(":id",$id);
        $stmt->execute();
    }

    public function searchTopics($search, $page=1){


        $perPage = 5;
        $pageOffset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE body LIKE :search ORDER BY created_at DESC LIMIT :page, :perPage");
        $stmt->bindValue(":search", "%" . $search . "%");
        $stmt->bindValue(":page", $pageOffset, PDO::PARAM_INT);
        $stmt->bindValue(":perPage", $perPage,  PDO::PARAM_INT);
        $stmt->execute();

        $topicsInfo = [];
        $topicsInfo['topics'] = [];

        if($stmt->rowCount() > 0){

            $data = $stmt->fetchAll();
            foreach($data as $topicItem){
                $topic = $this->buildTopic($topicItem);
                $topicsInfo['topics'][] = $topic;
            }
        }

        $numPages = $this->countAllTopics($perPage, $search);
        $topicsInfo['pages'] = $numPages;
        return $topicsInfo;
    }

    public function findByCategory($category=false){

        if($category){
            $stmt = $this->pdo->prepare("SELECT * FROM topics WHERE category=:category");
            $stmt->bindValue(":category",$category);
        }else{
            $stmt = $this->pdo->prepare("SELECT * FROM topics");
        }
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

}