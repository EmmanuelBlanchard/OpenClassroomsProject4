<section>
    <h2>Liste des épisodes</h2>
    
    <?php foreach($data['allpostspagination'] as $post): ?>

    <article>
        <h3>Épisode <?=$post['title']?></h3>
        <p class="pTitleIntroductionToTheEpisode">Introduction</p>
        <p class="pIntroductionToTheEpisode"><?=$post['introduction']?></p>
        <p class="pCreatedAt">Publié <?=$post['post_date_fr']?> </p>
        <a href="index.php?action=detailOfPost&amp;id=<?=$post['id']?>" class="linkReadTheEntireEpisode">Lire l'épisode en entier</a>
    </article>
    
</section>

<?php endforeach; ?>

<div class="divLinkPage">
    <a href="index.php?action=listOfPosts&page=<?=$data['previouspage']?>" class="linkPreviousPage">Page Précèdente</a>
    <a href="index.php?action=listOfPosts&page=<?=$data['nextpage']?>" class="linkNextPage">Page Suivante</a>
</div>
    