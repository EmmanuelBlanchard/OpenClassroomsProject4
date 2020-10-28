<!-- template bootstrap sign in -->
<div class="text-center">   
    <form method="post" action="index.php?action=login" class="form-signin">
        <img class="mb-4" src="./images/blogger-svgrepo-com.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Veuillez vous connecter</h1>
        <div class="form-label-group">
            <label for="pseudo" class="sr-only">Pseudo</label>
            <input id="pseudo" class="form-control" name="pseudo" type="text" placeholder="Pseudo" required="" autofocus="">
        </div>
        <div class="form-label-group">
            <label for="password" class="sr-only">Mot de passe</label>
            <input id="password" class="form-control" name="password" type="password" placeholder="Mot de passe" required="">
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Se souvenir de moi
            </label>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Se connecter</button>
        <p class="mt-5 mb-3 text-muted">© 2020</p>
        
    </form>
    <a class="btn btn-dark" href="index.php?action=home">Retour</a>
</div>

