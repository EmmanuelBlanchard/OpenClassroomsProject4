<section>
    <h2>Liste des trois derniers épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3><?=$post['title']?></h3>
        <p><?=$post['introduction']?></p>
        <p class="pCreatedAt">Écrit le <?=$data['onepost']['created_at']?></p>
        <a href="index.php?action=post&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire la suite</a>
    </article>
    
</section>
<?php endforeach; ?>