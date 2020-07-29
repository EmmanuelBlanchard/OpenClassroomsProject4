<section>
    <h2>Details des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <?php foreach($data['allcomments'] as $comment): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['created_at']?></p>
    </article>
</section>
<?php endforeach; ?>

<!-- chercher ajout commentaires table différente -->
<section>

    <article>
        <h4>Commentaires</h4>
        <p><?=$comment['author']?></p>
        <p><?=$comment['content']?></p>
        <p><?=$comment['created_at']?></p>
    </article>
    
    <!-- ajouter formulaire -->

</section>
<?php endforeach; ?>