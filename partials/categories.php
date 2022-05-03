<?php

require_once("dao/CategoryDaoMysql.php");

$categoryDao = new CategoryDaoMysql($pdo);

$categories = $categoryDao->returnCategories($limitNumCategories);

?>

<!-- selected para selecionar categoria -->

<section class="categories">
    <p class="title">Matérias</p>
    <ul class="navbar-nav">

        <?php foreach($categories as $category):?>
            <li class="nav-item">
                <a href="<?=$base?>categories.php?id=<?=$category->id?>" class="nav-link"><i class="bi bi-play-fill"></i><?=$category->name?></a>
            </li>
        <?php endforeach?>

        <li class="nav-item more-categories">
            <a href="<?=$base?>categories.php"><i class="bi bi-three-dots"></i></a>
        </li>
    </ul>
</section>