<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['post']['title']?></h3>
        <?=$data['post']['content']?>
        <p class="pCreatedAt">Publié <?=$data['post']['post_date_fr']?></p>
    </article>

    <a href="index.php?action=detailOfPost&amp;id=<?=$data['previouspost']?>" class="linkPreviousPost">Épisode précèdent</a>
    <a href="index.php?action=detailOfPost&amp;id=<?=$data['nextpost']?>" class="linkNextPost">Épisode suivant</a>

</section>

<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>        
        <?php if ((int)$post['report']===1): ?>
            <h5>Commentaire de </h5>
            <p class="pPseudoComments"><?=$post['pseudo']?></p>
            <p class="pDateComments"><?=$post['comment_date_fr']?> </p>
            <p>Ce commentaire a été signalé</p>
        <?php else: ?>
            <h5>Commentaire de </h5>
            <p class="pPseudoComments"><?=$post['pseudo']?></p>
            <p class="pDateComments"><?=$post['comment_date_fr']?> </p>
            <p><?=$post['comment']?><p>
            <div class="buttonReport">
                <a href="index.php?action=report&amp;commentid=<?=$post['id']?>&amp;id=<?=$post['post_id']?>" class="linkToTheReportOfThePostComment">Signaler</a>
            </div>
        <?php endif ?>

        <a href="index.php?action=detailOfPost&amp;id=<?=$data['previouscomments']?>" class="linkPreviousComment">Commentaires précédents</a>
        <a href="index.php?action=detailOfPost&amp;id=<?=$data['nextcomments']?>" class="linkNextComment">Commentaires suivants</a>

    </article>
    <?php endforeach; ?>
</section>

<section class="sectionPostComment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4>
        <form class="commentForm" method="post" action="index.php?action=addComment&amp;id=<?=$data['post']['id']?>">
            <p class="commentFormComment">
                <label for="comment">Commentaire <span>(obligatoire)</span> </label>
                <textarea name="comment" id="comment" rows="10" cols="50" required></textarea>
            </p>
            <p class="commentFormPseudo">
                <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
                <input id="pseudo" name="pseudo" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
</section>