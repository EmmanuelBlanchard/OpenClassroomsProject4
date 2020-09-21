<section>
    <h2>Accès à la page d'administration</h2>

    <form method="post" action="index.php?action=accessToTheAdminLoginPage">
        <p class="loginFormPseudo">
            <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
            <input id="pseudo" name="pseudo" type="text" value="" size="30" maxlength="245" required>
        </p>
        <p class="loginFormPassword">
            <label for="password">Mot de passe <span>(obligatoire)</span> </label>
            <input id="password" name="password" type="password" value="" size="30" maxlength="245" required>
        </p>

        <div class="checkbocRemenberLogin">
            <input type="checkbox" id="remenberLogin" name="remenber" value="1">
            <label for="remenberLogin">Se souvenir de moi</label>
        </div>

        <a class="aNewPassword" href="index.php?action=setNewPassword">
            <span>Mot de passe oublié ?</span>
        </a>

        <p>
            <input type="submit" class="inputTypeSubmitValidateLogin" value="Se connecter" />
        </p>
    </form>

</section>