<h2>Ajouter un épisode</h2>
<div class="row justify-content-center pt-3 pb-2 mb-3">
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
            <input type="hidden" name="token" id="token" value="<?php
            //Le champ caché a pour valeur le jeton
            //echo $token;
                ?>"/>
            <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour</a>

            <a class="btn btn-primary" href="index.php?action=draftEpisode">Brouillon</a>
            <button class="btn btn-primary">Publier</button>
        </form>
    </section>
</div>