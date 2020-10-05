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
        
        <!-- Tableau utilisant thead, tfoot, et tbody -->
        <table>
        <thead>
            <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Commentaires</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tdNumberEpisode"><?=$post['title']?> <?=$post['chapter']?></td>
                <td class="tdDate"><?=$post['post_date_fr']?></td>
                <td class="tdComment">fghtyikiozedzere</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
            <td>Pied de tableau 1</td>
            </tr>
        </tfoot>
        </table>
    <?php endforeach; ?>

    <?php foreach($data['allcomment'] as $post): ?>
        <table>
        <thead>
            <tr>
                <th>Commentaires</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$post['comment']?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
            <td>Pied de tableau 1</td>
            </tr>
        </tfoot>
        </table>
    <?php endforeach; ?>

</section>