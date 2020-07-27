<section>
    <h2>Tous les épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3><?=$post['title']?></h3>
        <p><?=$post['introduction']?></p>
        <a href="index.php?action=post&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire la suite</a>
    </article>
    
</section>
<?php endforeach; ?>