<?php if ($data['errortab'] === null): ?>
    <section>
        <p class="pError"> Erreur : l'affichage des erreurs n'est pas possible. </p>
    </section>
<?php elseif ($data['errortab'] !== null): ?>
        <?php foreach($data['errortab'] as $post): ?>
            <article>
                <h3>Erreur</h3>
                <p> <?=$post['errorName']?> </p>
                <p> <?=$post['errorValue']?> </p>
                <a href="index.php?action=home" class="linkToTheRestOfThePost">Accueil</a>
            </article>
    <?php endforeach; ?>
<?php endif; ?>