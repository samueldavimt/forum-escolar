<?php

require_once("models/User.php");
require_once("dao/TopicLikeDaoMysql.php");
require_once("dao/AnswerDaoMysql.php");


class UserDaoMysql implements UserDao{

    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    public function buildUser($data){

        $user = new User();

        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->avatar = $data['avatar'];
        $user->grade = $data['grade'];
        $user->shift = $data['shift'];
        $user->created_at = $data['created_at'];
        $user->token = $data['token'];

        $topicLikeDao = new TopicLikeDaoMysql($this->pdo);
        $answerDao = new AnswerDaoMysql($this->pdo);

        $user->countLikes = count($topicLikeDao->getAllLikesFrom($user->id));
        $user->answers = $answerDao->getAnswersFrom($user->id);

        return $user;
    }

    public function insert(User $user){

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, grade, shift, token, created_at) VALUES (:name, :email, :password, :grade, :shift, :token, :created_at)");

        $stmt->bindValue(":name",$user->name);
        $stmt->bindValue(":email",$user->email);
        $stmt->bindValue(":password",$user->password);
        $stmt->bindValue(":grade",$user->grade);
        $stmt->bindValue(":shift",$user->shift);
        $stmt->bindValue(":token",$user->token);
        $stmt->bindValue(":created_at",$user->created_at);
        $stmt->execute();


    }

    public function delete($id){}

    public function update(User $user){

        $stmt = $this->pdo->prepare("UPDATE users SET 
        name=:name, email=:email, password=:password, grade=:grade, shift=:shift, token=:token, created_at=:created_at 
        WHERE id=:id");

        $stmt->bindValue(":name",$user->name);
        $stmt->bindValue(":email",$user->email);
        $stmt->bindValue(":password",$user->password);
        $stmt->bindValue(":grade",$user->grade);
        $stmt->bindValue(":shift",$user->shift);
        $stmt->bindValue(":token",$user->token);
        $stmt->bindValue(":created_at",$user->created_at);
        $stmt->bindValue(":id",$user->id);
        $stmt->execute();

    }

    public function findByToken($token){

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token=:token LIMIT 1");
        $stmt->bindValue(":token",$token);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $user = $this->buildUser($data);
            return $user;

        }else{
            return false;
        }
    }

    public function findByEmail($email){

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
        $stmt->bindValue(":email",$email);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $user = $this->buildUser($data);
            return $user;

        }else{
            return false;
        }
    }

    public function findById($id){

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
        $stmt->bindValue(":id",$id);
        $stmt->execute();

        if($stmt->rowCount() > 0){

            $data = $stmt->fetch();
            $user = $this->buildUser($data);
            return $user;

        }else{
            return false;
        }
    }

}