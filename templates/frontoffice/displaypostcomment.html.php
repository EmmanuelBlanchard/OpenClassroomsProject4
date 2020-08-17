<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['episode']['episode_created_the']?></p>
    </article>
</section>

<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>
        <p class="pAuthorComments"><?=$post['author']?></p>
        <p class="pDateComments"><?=$post['comment_created_the']?></p>
        <p class="pComments"><?=$post['comment']?></p>
        <a href="index.php?action=reportComment&id=<?=$post['episode_id']?>" class="linkToTheReportOfThePostComment">Signaler</a>
    </article>
    <?php endforeach; ?>
</section>