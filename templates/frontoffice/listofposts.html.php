<?php if ($data['allpostspagination'] === null): ?>
    <section>
        <p class="pError"> Erreur : l'affichage de la liste des épisodes n'est pas possible </p>
    </section>
<?php elseif ($data['allpostpagination'] !== null): ?>
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
        <?php if ($data['previouspage'] !== null): ?>
            <a href="index.php?action=listOfPosts&page=<?=$data['previouspage']?>" class="linkPreviousPage">Page précèdente</a>
        <?php endif?>
        <?php if ($data['nextpage'] !== null): ?>
            <a href="index.php?action=listOfPosts&page=<?=$data['nextpage']?>" class="linkNextPage">Page suivante</a>
        <?php endif?>
    </div>
<?php endif?>