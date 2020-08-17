<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Publié <?=$data['episode']['date_episode_created_the']?></p>
    </article>
</section>

<!-- Probleme selection css, si veux cibler .pComments, n'affiche que le premier, pas la suite des <p> n'ont pas la class -->
<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>
        <h5>Commentaire</h5> <!-- Ajout balise h5 sinon pas compatible w3c -->
        <p class="pAuthorComments"><?=$post['author']?></p>
        <p class="pDateComments"><?=$post['date_comment_created_the']?> </p>
        <p class="pComments"><?=$post['comment']?></p>
        <div class="buttonsReportReply">
            <a href="index.php?action=reportComment&id=<?=$post['episode_id']?>" class="linkToTheReportOfThePostComment">Signaler</a>
            <a href="index.php?action=replyComment&id=<?=$post['episode_id']?>" class="linkToTheReplyOfThePostComment">Répondre</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>

<!-- Suppression de la balise article car faut une balise h5 ? -->
<section class="sectionPostcomment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4><!--
    <article>-->
        <form class="commentForm" action="index.php?action=addComment&id=<?=$data['episode']['id']?>" method="post">
            <p class="commentFormComment">
                <label for="comment">Commentaire <span>(obligatoire)</span> </label>
                <textarea name="comment" id="comment" rows="10" cols="50" required></textarea>
            </p>
            <p class="commentFormAuthor">
                <label for="author">Nom <span>(obligatoire)</span> </label>
                <input id="author" name="author" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p class="commentFormEmail">
                <label for="email">Courriel <span>(obligatoire)</span> </label>
                <input id="email" name="email" type="email" value="" size="30" maxlength="100" required>
            </p>
            <p class="commentFormUrl">
                <label for="url">Site web</label> 
                <input id="url" name="url" type="url" value="" size="30" maxlength="200">
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form><!--
    </article>-->
</section>


