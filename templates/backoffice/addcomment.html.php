<main class="container">
    <div class="row">
        <section class="col-12">
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
            <h1>Ajouter un commentaire</h1>
            <form method="post">
                <div class="form-group">
                    <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
                    <input id="pseudo" class="form-control" name="pseudo" type="text" value="" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="comment">Commentaires <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="comment" name="comment" value="" size="30" maxlength="245"></textarea>
                </div>
                <div class="form-group">
                    <label for="post_id">Id de l'épisode <span>(obligatoire)</span> </label>
                    <input id="post_id" class="form-control" name="post_id" type="number" value="" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="report">Signaler <span>(obligatoire)</span> </label>
                    <input id="report" name="report" class="form-control" type="number" value="" size="30" maxlength="40">
                </div>
                <a class="btn btn-primary" href="index.php?action=readComments">Retour</a>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
    </div>
</main>
