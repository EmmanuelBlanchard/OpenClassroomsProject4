<section>
    <h2>Details des épisodes</h2>

    <?php foreach($episode['episode'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['episode_created_the']?></p>
    </article>
</section>

<?php endforeach; ?>

<section>

    <?php foreach($commentaires['allcomments'] as $comment): ?>
    <article>
        <h4>Commentaires</h4>
        <p>Pseudo : <?=$comment['pseudo']?></p>
        <p>Commentaire : <?=$comment['comment']?></p>
        <p>Publié le : <?=$comment['comment_created_the']?></p>
    </article>
    
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