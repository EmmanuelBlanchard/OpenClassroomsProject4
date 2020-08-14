<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['episode']['episode_created_the']?></p>
    </article>
</section>

<!-- Reflexion nommage class de balise <p> -->
<!-- Reflechir pour l'affichage de la date du commentaire : 2020-06-25 12:07:49 => 25 Juin 2020 à 12 h 07 min | 25 Juin 2020 - 12h 07 -->
<!-- Probleme selection css, si veux cibler .pComments, n'affiche que le premier pas la suite des <p> n'ont pas la class -->
<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>
        <p class="pAuthorComments"><?=$post['author']?></p>
        <p class="pDateComments"><?=$post['comment_created_the']?></p>
        <p class="pComments"><?=$post['comment']?></p>
        <!-- Ajout boutons, liens : Signaler Repondre -->
        <a href="index.php?action=reportComment&id=<?=$post['episode_id']?>\" class="linkToTheReportOfThePostComment">Signaler</a>
        <a href="index.php?action=replyComment&id=<?=$post['episode_id']?>\" class="linkToTheReplyOfThePostComment">Répondre</a>
    </article>
    <?php endforeach; ?>
</section>