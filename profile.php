<?php 

require_once("config/globals.php");
require_once("models/Auth.php");
require_once("dao/TopicDaoMysql.php");
require_once("dao/UserDaoMysql.php");
require_once("models/Filter.php");
require_once("models/Redirect.php");

$auth = new Auth($pdo, $base);
$userDao = new UserDaoMysql($pdo);
$topicDao = new TopicDaoMysql($pdo);
$filter = new Filter();

$userInfo = $auth->checkToken(true);

$idUser = $userInfo->id;

if(isset($_GET['id'])){
   $idUser =  $filter->id($_GET['id']);
}

$currentUser = $userDao->findById($idUser);

if(!$currentUser){
    Redirect::local($base, 'index.php');
}

$userTopics = $topicDao->getTopicsFrom($currentUser->id);

// echo "<pre>";
// print_r($currentUser);
// echo "</pre>";

require_once("partials/header.php");
?>

<div class="container main">

    <section class="profile">
        <div class="profile-head">
            <div class="profile-head-cover">
                <img src="<?=$base?>media/covers/1920x1080-silver-lake-blue-solid-color-background.jpg" alt="">
            </div>

            <div class="profile-head-info">
                <div class="profile-head-info-user">
                    <div class="user-avatar" style="background-image: url('<?=$base?>media/avatars/<?=$userInfo->avatar?>');"></div>
                    
                    <div>
                        <div class="username"><?=$currentUser->shortName()?></div>
                        <p><?=$currentUser->shift?>  - <?=$currentUser->grade?>ºano</p>
                    </div>
                </div>

                <div class="profile-head-actions">
                    <div>
                        <p><?=count($userTopics)?></p>
                        <p>Perguntas</p>
                    </div>

                    <div>
                        <p><?=count($currentUser->answers)?></p>
                        <p>Respostas</p>
                    </div>

                    <div>
                        <p><?=$currentUser->countLikes?></p>
                        <p>Likes</p>
                    </div>
                </div>
            </div>


        </div>

        <div class="profile-body">
            <div class="info-user">
                <ul>
                    <li><i class="bi bi-calendar-check-fill"></i> <a href=""><?=$currentUser->grade?>ºano</a></li>
                    <li><i class="bi bi-clock-fill"></i><a href=""><?=$currentUser->shift?></a></li>
                </ul>
            </div>

            <div class="topics-user">
                <h4>Meus Tópicos</h4>
                <?php foreach($userTopics as $topicItemPreview):?>
                    <?php require("partials/topic_item_preview.php")?>

                <?php endforeach?>
               

            </div>
        </div>
    
    </section>
</div>

<?php require_once("partials/footer.php")?>