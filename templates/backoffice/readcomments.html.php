<?php if ($data['allcommentspagination'] === null): ?>
    <section>
        <p class="pError"> Erreur : l'affichage de la liste des commentaires n'est pas possible </p>
    </section>
<?php elseif ($data['allcommentspagination'] !== null): ?>
    <h2>Liste des commentaires</h2>
    <?php if ($data['sessionerreur'] !== null): ?>
        <div class="alert alert-danger" role="alert">
            <?= $data['sessionerreur'] ?>
        </div>
    <?php endif; ?>

    <?php if ($data['sessionmessage'] !== null): ?>
        <div class="alert alert-success" role="alert">
            <?= $data['sessionmessage'] ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="text-center">
                <tr>
                    <th>ID</th>
                    <th>Épisode n°</th>
                    <th>Auteur</th>
                    <th>Commentaire</th>
                    <th>Envoyé le</th>
                    <th>Signalé</th>
                    <th>Approuvé</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['allcommentspagination'] as $post): ?>
                    <tr>
                        <td data-title="ID"><?=$post['id']?></td>
                        <td data-title="Épisode n°"><?=$post['chapter']?></td>
                        <td data-title="Auteur"><?=$post['pseudo']?></td>
                        <td data-title="Commentaire"><?=$post['comment']?></td>
                        <td data-title="Envoyé le"><?=date("d/m/Y", strtotime($post['comment_date']));?></td>
                        <td data-title="Signalé"><?php if ((int)$post['reported']===1): ?> Oui <?php else: ?> Non <?php endif; ?></td>
                        <td data-title="Approuvé"><?php if ((int)$post['approved']===1): ?> Oui <?php else: ?> Non <?php endif; ?></td>
                        <td data-title="Supprimer"><a class="btn btn-primary" href="index.php?action=deleteComment&id=<?=$post['id']?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation read of comments">
        <ul class="pagination pagination-lg justify-content-center">
            <?php if ($data['previouspage'] !== null): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readComments&page=1" aria-label="First Page">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readComments&page=<?=$data['previouspage']?>" aria-label="Previous">
                        <span aria-hidden="true">&#139;</span>
                    </a>
                </li>
            <?php endif?>
            <?php if ($data['nextpage'] !== null): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readComments&page=<?=$data['nextpage']?>" aria-label="Next">
                        <span aria-hidden="true">&#155;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="index.php?action=readComments&page=<?=$data['lastpage']?>" aria-label="Last Page">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif?>
        </ul>
    </nav>

<?php endif; ?>