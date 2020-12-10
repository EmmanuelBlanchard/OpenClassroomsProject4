<div class="welcome-panel-content">
    <h2>Bienvenue sur le Blog de Jean Forteroche</h2>
    <?php if ($data['sessionmessage'] !== null): ?>
        <div class="alert alert-success" role="alert">
            <?= $data['sessionmessage'] ?>
        </div>
    <?php endif; ?>
        <p> Votre profil est <?=$data['pseudo']; ?> </p>
        <p> Votre identifiant est <?=$data['id']; ?> </p>

        <ul> Episodes
            <li>Il y a <?=$data['nbTotalEpisodesPublish']; ?> épisodes publiés</li>
            <li>Il y a <?=$data['nbTotalEpisodesDraft']; ?> brouillons d'épisodes</li>
            <li>Il y a <?=$data['nbTotalEpisodesPublish']; ?> épisodes créés au total</li>
        </ul>

        <ul> Commentaires
            <li>Il y a <?=$data['nbTotalComments']; ?> commentaires sur le site</li>
            <li>Il y a <?=$data['nbTotalCommentsReported']; ?> commentaires reportés sur le site</li>
            <li>Il y a <?=$data['nbTotalCommentsApproved']; ?> commentaires approuvés sur le site</li>
        </ul>

</div>