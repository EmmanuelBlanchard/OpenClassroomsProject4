<?php
    if(!isset($_SESSION)) 
    {
        // On demarre la session
        session_start();
    } 
?>
<?php
    if(!empty($_SESSION['erreur'])) {
        echo '<div class="alert alert-danger" role="alert">
                '. $_SESSION['erreur'].'
            </div>';
        $_SESSION['erreur'] = "";
    } 
?>
<?php
    if(!empty($_SESSION['message'])) {
        echo '<div class="alert alert-success" role="alert">
                '. $_SESSION['message'].'
            </div>';
            $_SESSION['message'] = "";
    } 
?>
<h2>Liste des commentaires signalés</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Episode</th>
                <th>Pseudo</th>
                <th>Commentaire</th>
                <th>Envoyé le</th>
                <th>Approuver</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['allreportedcomment'] as $post): ?>
                <tr>
                    <td><?=$post['id']?></td>
                    <td><?=$post['post_id']?></td>
                    <td><?=$post['pseudo']?></td>
                    <td><?=$post['comment']?></td>
                    <td><?=date("d/m/Y", strtotime($post['comment_date']));?></td>
                    <td><a class="btn btn-primary" href="index.php?action=approveComment&id=<?=$post['id']?>">Approuver</a></td>
                    <td><a class="btn btn-primary" href="index.php?action=deleteComment&id=<?=$post['id']?>">Supprimer</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        
    </table>
    <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
</div>