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
            <h1>Liste des commentaires signalés</h1>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Commentaire</th>
                    <th>Envoyé le</th>
                    <th>Approuver</th>
                    <th>Supprimer</th>
                </thead>
                <tbody>
                    <?php foreach($data['allreportedcomment'] as $post): ?>
                        <tr>
                            <td><?=$post['id']?></td>
                            <td><?=$post['pseudo']?></td>
                            <td><?=$post['comment']?></td>
                            <td><?=$post['comment_date']?></td>
                            <td><a class="btn btn-primary" href="index.php?action=approveComment&id=<?=$post['id']?>">Approuver</a></td>
                            <td><a class="btn btn-primary" href="index.php?action=deleteComment&id=<?=$post['id']?>">Supprimer</a></td>
                            
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
        </section>
    </div>
</main>