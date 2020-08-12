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

<!-- Chercher pourquoi la balise section ne s'affiche pas de la meme dimension que les deux balises sections au dessus ?? -->
<section class="sectionPostcomment">
    <h4 class="sectionH4TitlePostComment"> Publier un commentaire</h4>
    <article>
        <form class="postCommentForm" action="index.php?action=addcomment&id=<?=$data['episode']['id']?>\" method="post">
            <p>
                <!--
                <label for="pseudo">Votre pseudo : </label>
                <input type="text" id="pseudo" name="pseudo" required /> --> 
                <!-- le code ci dessus n'affiche pas l'input ?? -->
                <label for="pseudo">Votre pseudo : </label> <input type="text" name="pseudo" id="pseudo" />
            </p>
            <p>
                <!--
                <label for="comment">Votre commentaire : </label>
                <textarea id="comment" name="comment" rows="10" cols="62" required>
                    Commentaire
                </textarea> -->
                <!-- le code ci dessus n'affiche pas l'input ?? -->
                <label for="comment">
                Votre Commentaire :
                </label>
                
                <textarea name="comment" id="comment" rows="10" cols="50">
                Commentaire
                </textarea>
            </p>
            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
    </article>
</section>


