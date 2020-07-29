<section>
    <h2>Letails des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p class="pIntroductionToTheEpisode">Introduction de l'épisode</p>
        <p><?=$post['content']?></p>
        <p class="pCreatedAt">Écrit le <?=$post['created_at']?></p>
    </article>

    <!-- <p>Commentaires<?=$post['comment']?></p> -->
    
</section>
<?php endforeach; ?>