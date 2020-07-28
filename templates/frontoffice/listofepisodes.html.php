<section>
    <h2>Tous les épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3><?=$post['title']?></h3>
        <a href="index.php?action=post&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire l'épisode</a>
    </article>
    
</section>
<?php endforeach; ?>