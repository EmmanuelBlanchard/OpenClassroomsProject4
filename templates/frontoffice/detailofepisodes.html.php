<section>
    <h2>Details des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['created_at']?></p>
    </article>
</section>
<?php endforeach; ?>

<!-- ajout des commentaires provient d'une table différente -->
<section>

    <?php foreach($data['allcomments'] as $comment): ?>
    
    <article>
        <h4>Commentaires</h4>
        <p><?=$comment['author']?></p>
        <p><?=$comment['content']?></p>
        <p><?=$comment['created_at']?></p>
    </article>
    
    <!-- Ajouter formulaire -->

    <article>
        <h4> Publier un commentaire : </h4>

        <form action="cible.php" method="post">
            <p>
                <label for="pseudo">Votre pseudo : </label>
                <input type="text" id="pseudo" name="pseudo" value="Pseudo" />
            </p>

            <p>
                <label for="comment">Votre commentaire : </label>
                <textarea name="message" id="comment" rows="8" cols="45" value="Commentaire"></textarea>
            </p>

            <p>
                <input type="submit" value="Publier" />
            </p>
            
        </form>
        
    </article>

</section>
<?php endforeach; ?>