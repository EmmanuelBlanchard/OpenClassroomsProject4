<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <?=$data['episode']['content']?>
        <p class="pCreatedAt">Publié <?=$data['episode']['episode_date_fr']?></p>
    </article>
</section>

<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>
        <h5>Commentaire de </h5>
        <p class="pAuthorComments"><?=$post['author']?></p>
        <p class="pDateComments"><?=$post['comment_date_fr']?> </p>
        <?=$post['comment']?>
        
        <!-- if $post['report'] === '1' {
            <p>Ce commentaire a déjà été signalé</p>
        } else {
            <p><a href="index.php?action=report&commentid= $post['id'] &id= $post['episode_id'] " class="linkToTheReportOfThePostComment">Signaler</a></p>
        }
        -->

        <div class="buttonReport">
            <a href="index.php?action=report&commentid=<?=$post['id']?>&id=<?=$post['episode_id']?>" class="linkToTheReportOfThePostComment">Signaler</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>

<section class="sectionPostComment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4>
        <form class="commentForm" method="post" action="index.php?action=addComment&id=<?=$data['episode']['id']?>">
            <p class="commentFormComment">
                <label for="comment">Commentaire <span>(obligatoire)</span> </label>
                <textarea name="comment" id="comment" rows="10" cols="50" required></textarea>
            </p>
            <p class="commentFormAuthor">
                <label for="author">Nom <span>(obligatoire)</span> </label>
                <input id="author" name="author" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
</section>


<?php

// Partie "Boucle"
//while ($element = $request->fetch()) {
    // C'est là qu'on affiche les données  :)
//}

?>

<?php
// Partie "Liens"
/* On calcule le nombre de pages */
$nombreDePages = ceil($nombredElementsTotal / $limit);

/* Si on est sur la première page, on n'a pas besoin d'afficher de lien
 * vers la précédente. On va donc ne l'afficher que si on est sur une autre
 * page que la première */
if ($page > 1):
    ?><a href="?page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
endif;

/* On va effectuer une boucle autant de fois que l'on a de pages */
for ($i = 1; $i <= $nombreDePages; $i++):
    ?><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
endfor;

/* Avec le nombre total de pages, on peut aussi masquer le lien
 * vers la page suivante quand on est sur la dernière */
if ($page < $nombreDePages):
    ?>— <a href="?page=<?php echo $page + 1; ?>">Page suivante</a><?php
endif;
?>
