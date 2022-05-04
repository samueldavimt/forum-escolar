<?php

require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Auth.php");

$topicDao = new TopicDaoMysql($pdo);
$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken(true);

$limitNumCategories = 7;

$topicsHome = $topicDao->getTopicsHome();

// echo "<pre>";
// print_r($topicsHome[0]);
// echo "</pre>";

require_once("partials/header.php");
require_once("partials/submenu_mobile.php");
?>

<div class="container main">

    <?php require_once("partials/categories.php")?>

    <section class="topics">
    
    <?php foreach($topicsHome as $topicItemPreview):?>
        <?php require("partials/topic_item_preview.php")?>
    <?php endforeach?>


        <nav class="pagination-menu" aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
       
    </section>

    <?php require_once("partials/ads.php")?>

</div>

<?php require_once("partials/footer.php")?>