<section>
    <h2>Details des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['created_at']?></p>

        <p class="pComment"> Commentaires </p>
    </article>

    <!-- chercher ajout commentaires table différente -->
    <!-- ajouter formulaire -->
    
</section>
<?php endforeach; ?>