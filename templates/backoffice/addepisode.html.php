<h2>Ajouter un épisode</h2>
<div class="row justify-content-center pt-3 pb-2 mb-3">
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
    <section class="col-10">
        <form method="post">
            <div class="form-group">
                <label for="title">Titre <span>(obligatoire)</span> </label>
                <input id="title" class="form-control" name="title" type="text" value="<?php if (isset($_POST['title'])){echo $_POST['title'];} ?>" size="30" maxlength="245">
            </div>
            <div class="form-group">
                <label for="chapter">Numéro de l'épisode <span>(obligatoire)</span> </label>
                <input id="chapter" class="form-control" name="chapter" type="number" value="<?php if (isset($_POST['chapter'])){echo $_POST['chapter'];} ?>" size="30" maxlength="245">
            </div>
            <div class="form-group">
                <label for="introduction">Introduction de l'épisode <span>(obligatoire)</span> </label>
                <textarea class="form-control" id="introduction" name="introduction" value="" size="30" maxlength="245" class="form-control"><?php if (isset($_POST['introduction'])){echo $_POST['introduction'];} ?> </textarea>
            </div>
            <div class="form-group">
                <label for="content">Contenu de l'épisode <span>(obligatoire)</span> </label>
                <textarea class="form-control" id="content" name="content" value="" size="30" maxlength="2000"><?php if (isset($_POST['content'])){echo $_POST['content'];} ?> </textarea>
            </div>
            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Statut de l'épisode</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="episodeStatus" id="episodeStatusDraft" value="draft" checked>
                            <label class="form-check-label" for="episodeStatusDraft">
                                Brouillon
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="episodeStatus" id="episodeStatusPublish" value="publish">
                            <label class="form-check-label" for="episodeStatusPublish">
                                Publié
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>            
            <button class="btn btn-primary">Enregister</button>
        </form>
    </section>
</div>