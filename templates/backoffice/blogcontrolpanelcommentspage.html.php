<section class="sectionControlPanelComments">
    <h2>Panneau de configuration du blog</h2>
    <p class="commentsTitle">Commentaires</p>
   
        <table>
            <thead>
                <tr>
                    <th scope="col">Auteur</th>
                    <th scope="col">Commentaire</th>
                    <th scope="col">ID</th>
                    <th scope="col">Envoyé le </th>
                    <th scope="col">Approuver </th>
                    <th scope="col">Supprimer </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['allcomment'] as $post): ?>
                    <tr>
                        <td><?=$post['pseudo']?></td>
                        <td><?=$post['comment']?></td>
                        <td><?=$post['id']?></td>
                        <td><?=$post['comment_date']?></td>
                        <td><a class="btn btn-primary" href="index.php?action=approveComment&id=<?=$post['post_id']?>">Approuver</a></td>
                                <td><a class="btn btn-primary" href="index.php?action=deleteComment&id=<?=$post['id']?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    
</section>