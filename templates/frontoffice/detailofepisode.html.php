<section>
    <h2>Details des épisodes</h2>

    <article>
        <h3>Épisode <?=$data['episode']['title']?></h3>
        <p><?=$data['episode']['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['episode']['episode_created_the']?></p>
    </article>
</section>

<section>
    <article>
        <h4>Commentaires</h4>
        
        <p>Pseudo : <?=$data['allcomment'][0]['pseudo']?></p>
        <p>Commentaire : <?=$data['allcomment'][0]['comment']?></p>
        <p>Publié le : <?=$data['allcomment'][0]['comment_created_the']?></p>
    </article>
    
</section>

<!-- Essai pour afficher tous les commentaires et pas seulement premier tableau [0] comme home.html.php ou listofepisodes.html.php avec boucle foreach php -->
<section>
    <h4 class="sectionH4TitleComments">Commentaires</h4>
    <?php foreach($data['allcomment'] as $post): ?>
    <article>    
        <p>Commentaire : <?=$post['comment']?></p>
        <p>Pseudo : <?=$post['pseudo']?></p>
        <p>Publié le : <?=$post['comment_created_the']?></p>
    </article>
</section>
<?php endforeach; ?>

<!-- Formulaire pour ecrire et publier un commentaire -->
<section>
    <article>
        <h4> Publier un commentaire : </h4>
    
        <form action="index.php?action=addcomment&id=<?=$data['episode']['id']?>" method="post">
            <div>
                <label for="pseudo">Votre pseudo : </label><br />
                <input type="text" id="pseudo" name="pseudo" />
            </div>
            
            <div>
                <label for="comment">Votre commentaire : </label><br />
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
