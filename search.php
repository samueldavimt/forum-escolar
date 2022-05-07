<?php

require_once("config/globals.php");
require_once("dao/UserDaoMysql.php");
require_once("dao/TopicDaoMysql.php");
require_once("models/Auth.php");
require_once("models/Filter.php");
require_once("models/Redirect.php");


$topicDao = new TopicDaoMysql($pdo);
$auth = new Auth($pdo, $base);
$filter = new Filter();

$userInfo = $auth->checkToken(true);

$limitNumCategories = 7;

if(!isset($_GET['search'])){
    Redirect::local($base, "index.php");
}

$search = Filter::input($_GET['search']);
$_SESSION['search'] = $search;

$searchValueInSession = "";
if(isset($_SESSION['search'])){
    $searchValueInSession = $_SESSION['search'];
}

$currentPage = 1;
if(isset($_GET['page'])){
    $currentPage = $filter->id($_GET['page']);
}

$topicsInfo = $topicDao->searchTopics($search,$currentPage);
// echo "<pre>";
// print_r($topicsInfo);
// echo "</pre>";

$totalPages = $topicsInfo['pages'];
$topicsHome = $topicsInfo['topics'];


$previusPage = $currentPage - 1;
if($previusPage < 1){
    $previusPage = 1;
}

$nextPage = $currentPage + 1;
if($nextPage > $totalPages){
    $nextPage = $totalPages;
}

require_once("partials/header.php");
require_once("partials/submenu_mobile.php");
?>

<div class="container main">

    <?php require_once("partials/categories.php")?>

    <section class="topics">
    
    <?php foreach($topicsHome as $topicItemPreview):?>
        <?php require("partials/topic_item_preview.php")?>
    <?php endforeach?>
    <?php if(!$topicsHome):?>
        <h3>Nenhum Tópico Encontrado!</h3>
    <?php endif?>

            <nav class="pagination-menu" aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="<?=$base?>search.php?page=<?=$previusPage?>&search=<?=$searchValueInSession?>">Anterior</a></li>

                <?php for($page=0;$page<$totalPages;$page++):?>
                    <li class="page-item"><a class="page-link" href="<?=$base?>search.php?page=<?=$page + 1?>&search=<?=$searchValueInSession?>"><?=$page + 1?></a></li>
                <?php endfor?>
                
                <li class="page-item"><a class="page-link" href="<?=$base?>search.php?page=<?=$nextPage?>&search=<?=$searchValueInSession?>">Próxima</a></li>
            </ul>
            </nav>
    </section>

    <?php require_once("partials/ads.php")?>

</div>

<?php require_once("partials/footer.php")?>