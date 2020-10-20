<?php
    if(!isset($_SESSION)) 
    {
        // On demarre la session
        session_start();
    } 
?>

<main class="container">
    <div class="row">
        <section class="col-12">
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
            <h1>Liste des épisodes</h1>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Numero</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Introduction</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($data['allpost'] as $post): ?>
                        <tr>
                            <td><?=$post['id']?></td>
                            <td><?=$post['chapter']?></td>
                            <td><?=$post['title']?></td>
                            <td><?=date("d/m/Y", strtotime($post['post_date']));?></td>
                            <td><?=$post['introduction']?></td>
                            <td><?=$post['author']?></td>
                            <td><a class="btn btn-primary" href="index.php?action=addEpisode">Ajouter</a><hr>
                            <a class="btn btn-primary" href="index.php?action=detailEpisode&id=<?=$post['id']?>">Voir</a><hr>
                            <a class="btn btn-primary" href="index.php?action=editEpisode&id=<?=$post['id']?>">Modifier</a><hr>
                            <a class="btn btn-primary" href="index.php?action=deleteEpisode&id=<?=$post['id']?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
        </section>
    </div>
</main>
