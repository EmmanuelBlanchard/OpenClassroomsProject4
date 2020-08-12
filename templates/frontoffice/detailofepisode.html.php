<section class="sectionDisplayEpisode">
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['episode']['episode_created_the']?></p>
    </article>
</section>

<!-- Reflexion nommage class de balise <p>,
 reflechir pour l'affichage de la date du commentaire : 2020-06-25 12:07:49 => 
 25 Juin 2020 à 12 h 07 min
 25 Juin 2020 - 12h 07 -->
<!-- couleur background : #025AA0  => couleur text : HEX: #ffffff ou HEX: #fefefe-->
<!-- Probleme selection css, si veux cibler .pComments, n'affiche que le premier pas la suite des <p> n'ont pas la class -->
<section class="sectionDisplayComments">
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>    
        <p class="pPseudoComments"><?=$post['pseudo']?></p>
        <p class="pDateComments"><?=$post['comment_created_the']?></p>
        <p class="pComments"><?=$post['comment']?></p>
    </article>
    <?php endforeach; ?>
</section>

<section class="sectionPostcomment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4>
    <article>
        <form class="commentForm" action="index.php?action=addcomment&id=<?=$data['episode']['id']?>\" method="post">
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
        </form>
    </article>
</section>


