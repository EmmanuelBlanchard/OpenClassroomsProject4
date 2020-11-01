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
<?php if ($data['allepisodespagination'] === null): ?>
    <section>
        <p class="pError"> Erreur : l'affichage de la liste des épisodes n'est pas possible </p>
    </section>
<?php elseif ($data['allepisodespagination'] !== null): ?>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['allepisodespagination'] as $post): ?>
                    <tr>
                        <td data-title="ID"><?=$post['id']?></td>
                        <td data-title="Numero"><?=$post['chapter']?></td>
                        <td data-title="Titre"><?=$post['title']?></td>
                        <td data-title="Date"><?=date("d/m/Y", strtotime($post['post_date']));?></td>
                        <td data-title="Introduction"><?=$post['introduction']?></td>
                        <td data-title="Actions"><a class="btn btn-primary" href="index.php?action=detailOfPost&id=<?=$post['id']?>">Voir</a><hr>
                        <a class="btn btn-primary" href="index.php?action=editEpisode&id=<?=$post['id']?>">Modifier</a><hr>
                        <a class="btn btn-primary" href="index.php?action=deleteEpisode&id=<?=$post['id']?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation read of episodes">
        <ul class="pagination pagination-lg justify-content-center">
            <?php if ($data['previouspage'] !== null): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readEpisodes&page=<?=$data['previouspage']?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif?>
            <li class="page-item"><a class="page-link" href="index.php?action=readEpisodes&page=1">1</a></li>
            <li class="page-item"><a class="page-link" href="index.php?action=readEpisodes&page=2">2</a></li>
            <li class="page-item"><a class="page-link" href="index.php?action=readEpisodes&page=3">3</a></li>
            <?php if ($data['nextpage'] !== null): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readEpisodes&page=<?=$data['nextpage']?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif?>
        </ul>
    </nav>

<?php endif; ?>