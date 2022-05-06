<?php

require_once("config/globals.php");
require_once("models/Filter.php");
require_once("models/Validate.php");
require_once("models/Redirect.php");
require_once("models/Auth.php");
require_once("dao/UserDaoMysql.php");

$auth = new Auth($pdo, $base);
$validate = new Validate($pdo);
$userDao = new UserDaoMysql($pdo);

$userInfo = $auth->checkToken(true);

$name = Filter::input($_POST['name']);
$email = Filter::input($_POST['email']);
$grade = Filter::input($_POST['grade']);
$shift = Filter::input($_POST['shift']);
$password = Filter::input($_POST['password']);
$confirm_password = Filter::input($_POST['confirm_password']);

if($name && $email && $grade && $shift){
     
    $userInfo->name = $name;

    if($validate->emailExists($email) && $email != $userInfo->email){
        $_SESSION['message'] = "Este Email já Está Cadastrado!";
        Redirect::local($base, "back");
    }

    if($validate->email($email)){
        $userInfo->email = $email;
    }

    if(in_array($grade, [1,2,3])){
        $userInfo->grade = $grade;
    }

    if(in_array($shift, ['Matutino', 'Vespertino'])){
        $userInfo->shift = $shift;
    }

    if(!empty($password)){
        if($password != $confirm_password){
            $_SESSION['message'] = "As Senhas Prescisam ser Iguais!";
            Redirect::local($base, "back");   
        }

        $passwordHash = $auth->buildPassword($password);
        $userInfo->password = $passwordHash;
    }

    $userDao->update($userInfo);
    Redirect::local($base, "back");
    
}

$_SESSION['message'] = "Insira Todos os Dados Corretamente!";
Redirect::local($base, "back");
