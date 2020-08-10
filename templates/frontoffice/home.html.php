<section>
    <h2>Liste des trois derniers épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        
        <h3>Épisode <?=$post['title']?></h3>

        <p><?=$post['introduction']?></p>

        <p class="pCreatedAt">Écrit le  <?=$post['episode_created_the']?></p>

        <a href="index.php?action=detailofepisode&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire la suite</a>
    </article>
    
</section>
<?php endforeach; ?>