<?php

require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Filter.php");
require_once("models/Redirect.php");


$topicDao = new TopicDaoMysql($pdo);
$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken(true);

$limitNumCategories = false;

$categoryParam = false;
if(isset($_GET['category'])){
    $categoryParam = Filter::input($_GET['category']);
}


$topicsHome = $topicDao->findByCategory($categoryParam);

require_once("partials/header.php");
require_once("partials/submenu_mobile.php");
?>

<div class="container main">

    <?php require_once("partials/categories.php")?>

    <section class="topics">

    <?php if($categoryParam):?>
        <h3>Resultados da Categoria: <?=$categoryParam?></h3>
    <?php else:?>
        <h3>Tópicos por Categoria</h3>
    <?php endif?>
    
    <?php foreach($topicsHome as $topicItemPreview):?>
        <?php require("partials/topic_item_preview.php")?>
    <?php endforeach?>
    <?php if(!$topicsHome):?>
        <h3>Nenhum Tópico Encontrado!</h3>
    <?php endif?>

       
    </section>

    <?php require_once("partials/ads.php")?>

</div>

<?php require_once("partials/footer.php")?>