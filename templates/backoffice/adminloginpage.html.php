<main class="container">
    <div class="row">
        <section class="col-12">
            <h1>Accès à la page d'administration</h1>
                <form method="post" action="index.php?action=login">
                        <div class="form-group">
                            <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
                            <input id="pseudo" class="form-control" name="pseudo" type="text" value="" size="30" maxlength="245">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe <span>(obligatoire)</span> </label>
                            <input id="password" class="form-control" name="password" type="password" value="" size="30" maxlength="245">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Se connecter</button>
                        </div>
                </fom>
                <a class="btn btn-primary" href="index.php?action=home">Retour vers le Blog de Jean Forteroche</a>
        </section>
    </div>
</main>