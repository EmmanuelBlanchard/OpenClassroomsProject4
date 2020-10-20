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
            <h1>Detail de l'épisode <?=$data['post']['chapter']?></h1>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Numero</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Introduction</th>
                    <th>Contenu</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php if ($data['post'] === null): ?>
                        <section>
                            <p class="pError">Erreur : l'affichage des épisodes de Details des épisodes n'est pas possible !</p>
                        </section>
                    <?php elseif ($data['post'] !== null): ?>
                        <tr>
                            <td><?=$data['post']['id']?></td>
                            <td><?=$data['post']['chapter']?></td>
                            <td><?=$data['post']['title']?></td>
                            <td><?=date("d/m/Y", strtotime($data['post']['post_date']));?></td>
                            <td><?=$data['post']['introduction']?></td>
                            <td><?=$data['post']['content']?></td>
                            <td><?=$data['post']['author']?></td>
                            <td><a class="btn btn-primary" href="index.php?action=addEpisode">Ajouter</a><hr>
                            <a class="btn btn-primary" href="index.php?action=editEpisode&id=<?=$data['post']['id']?>">Modifier</a><hr>
                            <a class="btn btn-primary" href="index.php?action=deleteEpisode&id=<?=$data['post']['id']?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour</a>        
        </section>
    </div>
</main>