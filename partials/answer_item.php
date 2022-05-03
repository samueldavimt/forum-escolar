<div class="answer-item">
    <h4>Resposta</h4>
    <div class="answer-item-head">
        <div class="answer-item-info topic-item-info">
            <div class="user-avatar" style="background-image: url('<?=$base?>media/avatars/<?=$answerItem->user->avatar?>');"></div>
            <div>
                <a href="" class="username"><?=$answerItem->user->name?></a>
                <p><?=$answerItem->user->shift?>  - <?=$answerItem->user->grade?>ºano</p>
            </div>
        </div>

        <span class="topic-item-states">
            <span><i class="bi bi-journal-check"></i> <?=$answerItem->created_at?></span>
        </span>
    </div>

    <div class="answer-item-body">
        <div class="answer-item-content">
            <?=$answerItem->getBody()?>
        </div>
    </div>

    <div class="answer-item-actions">
        <button id="like-answer"><i class="bi bi-heart liked"></i><span class="count-like"><?=$answerItem->countLikes?></span></button>
        <span><abbr title="Denunciar"><i class="bi bi-flag-fill"></i></abbr></span>                </div>
</div>