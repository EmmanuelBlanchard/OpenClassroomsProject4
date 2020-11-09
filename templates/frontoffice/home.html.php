<?php if ($data['allposts'] === null): ?>
    <section>
        <p class="pError"> Erreur : l'affichage de la liste des trois derniers épisodes n'est pas possible. </p>
    </section>
<?php elseif ($data['allposts'] !== null): ?>
    <section>
        <h2>Liste des trois derniers épisodes</h2>

        <?php foreach($data['allposts'] as $post): ?>
                <article>
                    <h3>Épisode <?=$post['title']?></h3>
                    <p><?=$post['introduction']?></p>
                    <p class="pCreatedAt">Publié <?=$post['post_date_fr']?> </p>
                    <a href="index.php?action=detailOfPost&amp;id=<?=$post['id']?>" class="linkToTheRestOfThePost">Lire la suite</a>
                </article>
    </section>
    <?php endforeach; ?>
<?php endif; ?>