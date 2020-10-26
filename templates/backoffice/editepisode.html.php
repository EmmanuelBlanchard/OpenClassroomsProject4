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
                    <input id="title" class="form-control" name="title" type="text" value="<?=$data['post']['title']?>" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="chapter">Numéro de l'épisode <span>(obligatoire)</span> </label>
                    <input id="chapter" class="form-control" name="chapter" type="number" value="<?=$data['post']['chapter']?>" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="introduction">Introduction de l'épisode <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="introduction" name="introduction" size="30" maxlength="245" class="form-control"><?=$data['post']['introduction']?></textarea>
                </div>
                <div class="form-group">
                    <label for="content">Contenu de l'épisode <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="content" name="content" size="30" maxlength="2000"><?=$data['post']['content']?></textarea>
                </div>
                <input type="hidden" name="id" value="<?=$data['post']['id']?>">
                <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour</a>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        <?php endif; ?> 
    </section>
</div>