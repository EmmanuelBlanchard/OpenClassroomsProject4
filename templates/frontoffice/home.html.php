<?php if ($data === null): ?>
    <section>
        <p> Il n'y a pas d'épisode </p>
        <a href="index.php?action=error">Page erreur</a>
        <a href="index.php?action=home">Accueil</a>
    </section>
<?php elseif ($data !== null): ?>
    <section>
        <h2>Liste des trois derniers épisodes</h2>

        <!-- Si $data === null =>  Whoops \ Exception \ ErrorException (E_WARNING)
Invalid argument supplied for foreach() --> 
        <?php foreach($data['allposts'] as $post): ?>

        <article>
            <h3>Épisode <?=$post['title']?></h3>
            <p><?=$post['introduction']?></p>
            <p class="pCreatedAt">Publié <?=$post['post_date_fr']?> </p>
            <a href="index.php?action=detailOfPost&amp;id=<?=$post['id']?>" class="linkToTheRestOfThePost">Lire la suite</a>
        </article>
        
    </section>
    <?php endforeach; ?>
<?php endif?>