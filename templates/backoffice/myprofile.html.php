
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
            <h2>Mon Profil</h2>
            <form method="post" action="index.php?action=">
                <div class="form-group">
                    <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
                    <input id="pseudo" class="form-control" name="pseudo" type="text" value="" size="30" maxlength="245" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span>(obligatoire)</span> </label>
                    <input id="email" class="form-control" name="email" type="email" value="" size="30" maxlength="245" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe <span>(obligatoire)</span> </label>
                    <input id="password" class="form-control" name="password" type="password" value="" size="30" maxlength="245" required>
                </div>
                <h3> Modifier le mot de passe </h3>
                <div class="form-group">
                    <label for="newpassword">Nouveau mot de passe <span>(obligatoire)</span> </label>
                    <input id="newpassword" class="form-control" name="newpassword" type="password" value="" size="30" maxlength="245" required>
                </div>
                <div class="form-group">
                    <label for="newpassword2">Reconfirmer le mot de passe <span>(obligatoire)</span> </label>
                    <input id="newpassword2" class="form-control" name="newpassword2" type="password" value="" size="30" maxlength="245" required>
                </div>
                <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
                <a class="btn btn-primary" href="index.php?action=readEpisodes">Retour Liste des épisodes</a>
                <button class="btn btn-primary">Valider le changement de mot de passe</button>
            </form>
        </section>
    </div>
</main>