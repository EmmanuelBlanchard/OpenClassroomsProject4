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
            <h1>Ajouter un épisode</h1>
            <form method="post">
                <div class="form-group">
                    <label for="title">Titre <span>(obligatoire)</span> </label>
                    <input id="title" class="form-control" name="title" type="text" value="" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="chapter">Numéro de l'épisode <span>(obligatoire)</span> </label>
                    <input id="chapter" class="form-control" name="chapter" type="number" value="" size="30" maxlength="245">
                </div>
                <div class="form-group">
                    <label for="content">Contenu de l'épisode <span>(obligatoire)</span> </label>
                    <textarea class="form-control" id="content" name="content" value="" size="30" maxlength="245"></textarea>
                </div>
                <div class="form-group">
                    <label for="introduction">Introduction de l'épisode <span>(obligatoire)</span> </label>
                    <textarea id="introduction" name="introduction" value="" size="30" maxlength="245" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="author">Auteur <span>(obligatoire)</span> </label>
                    <input id="author" name="author" class="form-control" type="text" value="" size="30" maxlength="40">
                </div>
                <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour</a>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
    </div>
</main>
