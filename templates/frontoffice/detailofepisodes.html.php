<section>
    <h2>Details des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['created_at']?></p>
    </article>
</section>


<!-- ajout des commentaires provient d'une table différente -->
<section>

    <!-- foreach($data['allcomments'] as $comment): -->

    <article>
        <h4>Commentaires</h4>
        <p>Auteur <!-- $comment['author'] --></p>
        <p>Contenu <!-- $comment['content'] --></p>
        <p>Publié le <!-- $comment['created_at'] -->  </p>
    </article>
    
    <!-- Ajouter formulaire -->
    <article>
        <h4> Publier un commentaire : </h4>

        <form action="CommentManager.php" method="post">
            <p>
                <label for="pseudo">Votre pseudo : </label>
                <input type="text" id="pseudo" name="pseudo" value="Pseudo" />
            </p>

            <p>
                <label for="comment">Votre commentaire : </label>
                <textarea name="message" id="comment" rows="10" cols="62">
                    Commentaire
                </textarea>
            </p>

            <p>
                <input type="submit" class="inputTypeSubmitPublishComment" value="Publier" />
            </p>
        </form>
    </article>

</section>

<?php endforeach; ?>