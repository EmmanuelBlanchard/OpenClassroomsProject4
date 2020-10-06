<section class="sectionControlPanelComments">
    <h2>Panneau de configuration du blog</h2>
    <p class="commentsTitle">Commentaires</p>
    <?php foreach($data['allcomment'] as $post): ?>
        <table>
            <thead>
                <tr>
                    <th scope="col">Auteur</th>
                    <th scope="col">Commentaire</th>
                    <th scope="col">Envoyé le </th>
                    <th scope="col">Approuver </th>
                    <th scope="col">Supprimer </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$post['pseudo']?></td>
                    <td><?=$post['comment']?></td>
                    <td><?=$post['comment_date']?></td>
                    <td>Ajouter un bouton Approuvé Pas approuvé puis message affichant</td>
                    <td>Ajouter un bouton Supprimé puis supprime le contenu de la base de donnees </td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>