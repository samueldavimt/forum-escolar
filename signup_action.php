<?php

require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Redirect.php");
require_once("models/Filter.php");
require_once("models/Validate.php");
require_once("models/Message.php");


$auth = new Auth($pdo, $base);
$filter = new Filter();
$newMessage = new Message();

$name = $filter->input($_POST['name']);
$email = $filter->input($_POST['email']);
$grade = $filter->input($_POST['grade']);
$shift = $filter->input($_POST['shift']);
$password = $filter->input($_POST['password']);
$confirm_password = $filter->input($_POST['confirm_password']);

if($name && $email && $grade && $shift && $password && $confirm_password){

    $validate = new Validate($pdo);

    $validateLenghts = $validate->lenghtLimit([$name, $email, $grade, $shift, $password], 30);

    if(!$validateLenghts){   
        $newMessage->return('error', 'Preencha os dados Corretamente!');

    }

    if(!$validate->email($email)){
        $newMessage->return('error', 'Email Inválido! Tente Novamente.');

    }

    if($validate->emailExists($email)){
        $newMessage->return('error', 'Este Email já está Cadastrado!');

    }

    if(!in_array($grade, ['1','2','3'])){
        $newMessage->return('error', 'Preencha os dados Correntamente!');

    }

    if(!in_array($shift, ['Matutino', 'Vespertino'])){
        $newMessage->return('error', 'Preencha os dados Correntamente!');

    }

    if($password !== $confirm_password){
        $newMessage->return('error', 'As Senhas devem ser Iguais!');

    }

    $auth->registerUser($name, $email, $grade, $shift, $password);
    $newMessage->return('success', 'Conta Criada com Sucesso!');

}else{

    $newMessage->return('error', 'Preencha Todos os Dados!');
}




