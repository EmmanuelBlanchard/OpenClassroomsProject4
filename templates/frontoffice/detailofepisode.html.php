<section>
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
<section>
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>    
        <p class="pPseudoComments"><?=$post['pseudo']?></p>
        <p class="pDateComments"><?=$post['comment_created_the']?></p>
        <p class="pComments"><?=$post['comment']?></p>
    </article>
    <?php endforeach; ?>
</section>

<section>
    <h4> Publier un commentaire</h4>
    <article>
        <form class="postCommentForm" action="index.php?action=addcomment&id=<?=$data['episode']['id']?>\" method="post">
            <div>
                <label for="pseudo">Votre pseudo : </label>
                <input type="text" id="pseudo" name="pseudo" />
            </div>
            
            <div>
                <label for="comment">Votre commentaire : </label>
                <textarea id="comment" name="comment" rows="10" cols="62">
                    Commentaire
                </textarea>
            </div>
            
            <div>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </div>
        </form>
    </article>
</section>


