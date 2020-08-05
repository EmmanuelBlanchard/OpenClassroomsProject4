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
    <?php foreach($commentaires['allcomments'] as $comment): ?>
    
    <article>
        <h4>Commentaires</h4>
        <p>Pseudo : <?=$comment['pseudo']?></p>
        <p>Commentaire : <?=$comment['comment']?></p>
        <p>Publié le : <?=$comment['comment_created_the']?></p>
    </article>
    
    <article>
    
</section>

<?php endforeach; ?>

<section>
    <article>
        <h4> Publier un commentaire : </h4>
    
        <form action="index.php?action=addcomment&amp;id=<?= $post['id'] ?>" method="post">
                <div>
                    <label for="pseudo">Pseudo : </label><br />
                    <input type="text" id="pseudo" name="pseudo" />
                </div>
                <div>
                    <label for="comment">Commentaire : </label><br />
                    <textarea id="comment" name="comment"></textarea>
                </div>
                <div>
                    <input type="submit" />
                </div>
        </form>
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