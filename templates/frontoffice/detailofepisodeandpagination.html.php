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


<p id="pagination">
				<?php

				echo 'Page : ';
                // Undefined variable: totalpagecomments
				for ($i = 1 ; $i <= $data['totalpagecomments'] /*$totalpagecomments*/ ; $i++)
				{
					if ($i == $data['page'] /*$page*/)
					{
						echo '<strong class="brown">' . $i . '<strong></a> ';
					}
					else
					{
						echo '<a href="index.php?action=postfront&page=' . $i . '&id='.htmlspecialchars($data['episode']['id']/*$post['id']*/).'">' . $i . '</a> ';
					}

				}
				?>
</p>
