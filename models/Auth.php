<?php

require_once("models/Redirect.php");
require_once("dao/UserDaoMysql.php");

class Auth{

    public $pdo;
    public $base;

    public function __construct($pdo, $base=false){
        $this->pdo = $pdo;
        $this->base = $base;
        $this->userDao = new UserDaoMysql($pdo);
    }

    public function checkToken($protected=false){

        if(isset($_SESSION['token'])){

            $token = filter_var($_SESSION['token'], FILTER_SANITIZE_SPECIAL_CHARS);

            $userInfo = $this->userDao->findByToken($token);

            if($userInfo){
                return $userInfo;

            }else{
                
                if($protected){
                    Redirect::local($this->base, "login.php");

                }else{
                    return false;
                }
            }

        }else{

            if($protected){
                Redirect::local($this->base, "login.php");

            }else{
                return false;
            }
        }
    }    


    public function buildToken(){

        return md5(time().rand(0,999));
    }

    public function buildPassword($password){

        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function registerUser($name, $email, $grade, $shift, $password){

        $token = $this->buildToken();
        $passwordHash = $this->buildPassword($password);

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->grade = $grade;
        $user->shift = $shift;
        $user->password = $passwordHash;
        $user->token = $token;
        $user->created_at = date("Y-m-d H:i:s");

        $_SESSION['token'] = $token;
        $this->userDao->insert($user);
    }

    public function validateLogin($email, $password){

        $user = $this->userDao->findByEmail($email);

        if($user){

            if(password_verify($password, $user->password)){

                $newToken = $this->buildToken();

                $_SESSION['token'] = $newToken;
                $user->token = $newToken;  
                $this->userDao->update($user);
                
            }
        }

        return false;
    }

}