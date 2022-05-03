<?php

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("models/Filter.php");
require_once("models/Validate.php");

$filter = new Filter();
$validate = new Validate($pdo);

$email = $filter->input($_POST['email']);
$password = $filter->input($_POST['password']);

if($email && $password){

    $validateLenghts = $validate->lenghtLimit([$email, $password], 30);

    if($validateLenghts){
        
        $auth = new Auth($pdo, $base);
        $auth->validateLogin($email, $password);

    }
}

$_SESSION['message'] = "Email e/ou Senha Incorretos!";
Redirect::local($base, "back");
