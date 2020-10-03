<section>
    <p class="pControlPanelPage">Mon Profil</p>

    <form method="post" action="index.php?action=newpassword">
        <p class="loginFormPseudo">
            <label for="pseudo">Pseudo <span>(obligatoire)</span> </label>
            <input id="pseudo" name="pseudo" type="text" value="" size="30" maxlength="245" required>
        </p>
        <p class="loginFormEmail">
            <label for="email">Email <span>(obligatoire)</span> </label>
            <input id="email" name="email" type="email" value="" size="30" maxlength="245" required>
        </p>

        <p class="loginFormPassword">
            <label for="password">Mot de passe <span>(obligatoire)</span> </label>
            <input id="password" name="password" type="password" value="" size="30" maxlength="245" required>
        </p>

        <p class="pControlPanelPage"> Modifier le mot de passe </p>

        <p class="loginFormNewPassword">
            <label for="newpassword">Nouveau mot de passe <span>(obligatoire)</span> </label>
            <input id="newpassword" name="newpassword" type="password" value="" size="30" maxlength="245" required>
        </p>

        <p class="loginFormNewPassword2">
            <label for="newpassword2">Reconfirmer le mot de passe <span>(obligatoire)</span> </label>
            <input id="newpassword2" name="newpassword2" type="password" value="" size="30" maxlength="245" required>
        </p>

        <p>
            <input type="submit" class="inputTypeSubmitChangePassword" value="Valider le changement de mot de passe" />
        </p>
    </form>

</section>