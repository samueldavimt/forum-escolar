<?php

$host = 'localhost';
$dbName = 'forum';
$user = 'samsepiol';
$pass = 't00r';

try{

    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user, $pass);

}catch(PDOException $e){
    echo $e.getMessage();
}