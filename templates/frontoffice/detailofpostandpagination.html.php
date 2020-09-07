<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['post']['title']?></h3>
        <?=$data['post']['content']?>
        <p class="pCreatedAt">Publié <?=$data['post']['post_date_fr']?></p>
    </article>
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
                <label for="pseudo">Nom <span>(obligatoire)</span> </label>
                <input id="pseudo" name="pseudo" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
</section>

<!-- Essai pagination   Undefined variable: currentPage  -->
<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="./?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for($page = 1; $page <= $pages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="./?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>
