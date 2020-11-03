<h2>Modifier un épisode</h2>
<div class="row justify-content-center pt-3 pb-2 mb-3">
    <section class="col-10">
        <?php if ($data['post'] === null): ?>
            <section>
                <p class="pError">Erreur : L'id n'est pas trouvé !</p>
            </section>
        <?php elseif ($data['post'] !== null): ?>
            <form method="post">
                <div class="form-group">
                    <label for="title">Titre <span>(obligatoire)</span> </label>
                    <input id="title" class="form-control" name="title" type="text" value="<?php if (isset($data['post']['title'])){echo htmlentities($data['post']['title'], ENT_COMPAT,'UTF-8', true);} ?>" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="chapter">Numéro de l'épisode <span>(obligatoire)</span> </label>
                    <input id="chapter" class="form-control" name="chapter" type="number" value="<?php if (isset($data['post']['chapter'])){echo htmlentities($data['post']['chapter'], ENT_COMPAT,'UTF-8', true);} ?>" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="introduction">Introduction de l'épisode <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="introduction" name="introduction" size="30" maxlength="245" class="form-control"><?php if (isset($data['post']['introduction'])){echo htmlentities($data['post']['introduction'], ENT_COMPAT,'UTF-8', true);} ?></textarea>
                </div>
                <div class="form-group">
                    <label for="content">Contenu de l'épisode <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="content" name="content" size="30" maxlength="2000"><?php if (isset($data['post']['content'])){echo htmlentities($data['post']['content'], ENT_COMPAT,'UTF-8', true);} ?></textarea>
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
                <input type="hidden" name="id" value="<?=$data['post']['id']?>">
                
                <button class="btn btn-primary">Envoyer</button>
            </form>
        <?php endif; ?> 
    </section>
</div>