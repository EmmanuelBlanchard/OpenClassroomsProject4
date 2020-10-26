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
<h2>Liste des épisodes</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Introduction</th>
                <th>Auteur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['allpost'] as $post): ?>
                <tr>
                    <td data-title="ID"><?=$post['id']?></td>
                    <td data-title="Numero"><?=$post['chapter']?></td>
                    <td data-title="Titre"><?=$post['title']?></td>
                    <td data-title="Date"><?=date("d/m/Y", strtotime($post['post_date']));?></td>
                    <td data-title="Introduction"><?=$post['introduction']?></td>
                    <td data-title="Auteur"><?=$post['author']?></td>
                    <td data-title="Actions"><a class="btn btn-primary" href="index.php?action=detailOfPost&id=<?=$post['id']?>">Voir</a><hr>
                    <a class="btn btn-primary" href="index.php?action=editEpisode&id=<?=$post['id']?>">Modifier</a><hr>
                    <a class="btn btn-primary" href="index.php?action=deleteEpisode&id=<?=$post['id']?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
</div>