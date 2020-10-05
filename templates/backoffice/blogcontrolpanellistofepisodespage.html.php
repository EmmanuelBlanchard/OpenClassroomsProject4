<section class="sectionControlPanelListOfEpisodes">

    <article>

    <a href="index.php?action=blogControlPanel" class="homeTab">Accueil</a>

    <a href="index.php?action=blogControlPanelMyProfile" class="myProfileTab">Mon profil</a>

    <a href="index.php?action=blogControlPanelListOfEpisodes" class="episodeListTab">Liste des épisodes</a>

    <a href="index.php?action=blogControlPanelCreateOfEpisode" class="createAnEpisodeTab">Création d'un épisode</a>

    <a href="index.php?action=blogControlPanelComments" class="commentsTab">Commentaires</a>

    <a href="index.php?action=logout" class="logoutTab">Se déconnecter</a>

    </article>

    <h2>Panneau de configuration du blog</h2>

    <p class="episodeListTitle"> Liste des épisodes</p>

    <?php foreach($data['allposts'] as $post): ?>
        
        <table>
            <thead>
                <tr>
                <th>Titre</th>
                <th>Numéro de l'épisode</th>
                <th>Date</th>
                <th>Introduction</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tdTitleEpisode"><?=$post['title']?></td>
                    <td class="tdNumberEpisode"><?=$post['chapter']?></td>
                    <td class="tdDate"><?=$post['post_date_fr']?></td>
                    <td class="tdComment"><?=$post['introduction']?></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>

</section>