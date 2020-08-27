<section>
    <h2>Liste des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p class="pTitleIntroductionToTheEpisode">Introduction</p>
        <p class="pIntroductionToTheEpisode"><?=$post['introduction']?></p>
        <p class="pCreatedAt">Publié <?=$post['episode_date_fr']?> </p>
        <a href="index.php?action=detailofepisode&id=<?=$post['id']?>" class="linkReadTheEntireEpisode">Lire l'épisode en entier</a>
    </article>
    
</section>
<?php endforeach; ?>