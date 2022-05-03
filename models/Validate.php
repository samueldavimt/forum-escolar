<?php

require_once("dao/CategoryDaoMysql.php");
require_once("dao/UserDaoMysql.php");


class Validate{

    public $pdo;
    
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function email($email){

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function lenghtLimit($values, $maxLenght){

        foreach($values as $value){

            if(strlen($value) > $maxLenght){ 
                return false;
            }else{
                return true;
            }
                  
        }
    }

    public function categoryExists($category){

        $categoryDao = new CategoryDaoMysql($this->pdo);

        $category = $categoryDao->findByCategory($category);
        return $category;
    }

    public function emailExists($email){

        $userDao = new UserDaoMysql($this->pdo);
        $user = $userDao->findByEmail($email);
        return $user;
    }


}