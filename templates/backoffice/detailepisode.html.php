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
<h2>Detail de l'épisode <?=$data['post']['chapter']?></h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Introduction</th>
                <th>Contenu</th>
                <th>Auteur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data['post'] === null): ?>
                <section>
                    <p class="pError">Erreur : l'affichage des épisodes de Details des épisodes n'est pas possible !</p>
                </section>
            <?php elseif ($data['post'] !== null): ?>
                <tr>
                    <td data-title="ID"><?=$data['post']['id']?></td>
                    <td data-title="Numero"><?=$data['post']['chapter']?></td>
                    <td data-title="Titre"><?=$data['post']['title']?></td>
                    <td data-title="Date"><?=date("d/m/Y", strtotime($data['post']['post_date']));?></td>
                    <td data-title="Introduction"><?=$data['post']['introduction']?></td>
                    <td data-title="Contenu"><?=$data['post']['content']?></td>
                    <td data-title="Auteur"><?=$data['post']['author']?></td>
                    <td data-title="Actions"><a class="btn btn-primary" href="index.php?action=addEpisode">Ajouter</a><hr>
                    <a class="btn btn-primary" href="index.php?action=editEpisode&id=<?=$data['post']['id']?>">Modifier</a><hr>
                    <a class="btn btn-primary" href="index.php?action=deleteEpisode&id=<?=$data['post']['id']?>">Supprimer</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour</a>
</div>