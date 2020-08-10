<section>
    <h2>Liste des épisodes</h2>

    <?php foreach($data['allposts'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p class="pIntroductionToTheEpisode">Introduction</p>
        <p><?=$post['introduction']?></p>
        <a href="index.php?action=detailofepisode&id=<?=$post['id']?>\" class="linkToTheRestOfThePost">Lire l'épisode en entier</a>
    </article>
    
</section>
<?php endforeach; ?>