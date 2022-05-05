<?php 

require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/TopicDaoMysql.php");
require_once("dao/AnswerDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Filter.php");
require_once("models/Redirect.php");

$auth = new Auth($pdo, $base);
$topicDao = new TopicDaoMysql($pdo);
$answerDao = new AnswerDaoMysql($pdo);
$filter = new Filter();

$userInfo = $auth->checkToken(true);

if(isset($_GET['id'])){
    $topicId = $filter->id($_GET['id']);
}

$topicItem = $topicDao->findById($topicId);

if(!$topicItem){
    Redirect::local($base, "index.php");
}


// echo "<pre>";
// print_r($topicItem);
// echo "</pre>";

require_once("partials/header.php");
?>

<div class="container main">

    <section class="discussion">
        <?php require_once("partials/topic_item.php")?>

        <?php if(count($topicItem->answers) > 0):?>
            <?php foreach($topicItem->answers as $answerItem):?>
                <?php require("partials/answer_item.php")?>
            <?php endforeach?>
        <?php endif?>
        
    </section>

    <?php require_once("partials/ads.php")?>

</div>

<?php require_once("partials/footer.php");?>