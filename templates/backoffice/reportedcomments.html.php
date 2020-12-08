<?php if ($data['allreportedcomment'] === null): ?>
    <h2>Liste des commentaires signalés</h2>
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
            <table class="table table-bordered table-hover table-sm">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Numéro de l'épisode</th>
                        <th>Pseudo</th>
                        <th>Commentaire</th>
                        <th>Envoyé le</th>
                        <th>Approuver</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-title="ID"></td>
                        <td data-title="Numéro de l'épisode"></td>
                        <td data-title="Pseudo"></td>
                        <td data-title="Commentaire"></td>
                        <td data-title="Envoyé le"></td>
                        <td data-title="Approuver"></td>
                        <td data-title="Supprimer"></td>
                    </tr>
                </tbody>
                
            </table>
            <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
        </div>
<?php elseif ($data['allcommentspagination'] !== null): ?>
    <h2>Liste des commentaires signalés</h2>
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
            <table class="table table-bordered table-hover table-sm">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Numéro de l'épisode</th>
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
                            <td data-title="ID"><?=$post['id']?></td>
                            <td data-title="Numéro de l'épisode"><?=$post['chapter']?></td>
                            <td data-title="Pseudo"><?=$post['pseudo']?></td>
                            <td data-title="Commentaire"><?=$post['comment']?></td>
                            <td data-title="Envoyé le"><?=date("d/m/Y", strtotime($post['comment_date']));?></td>
                            <td data-title="Approuver"><a class="btn btn-primary" href="index.php?action=approveComment&id=<?=$post['id']?>">Approuver</a></td>
                            <td data-title="Supprimer"><a class="btn btn-primary" href="index.php?action=deleteComment&id=<?=$post['id']?>">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                
            </table>
            <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
        </div>
<?php endif; ?>