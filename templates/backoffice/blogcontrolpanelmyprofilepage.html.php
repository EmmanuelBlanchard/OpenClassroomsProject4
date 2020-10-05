<section class="sectionControlPanelMyProfile">
    
    <h2>Panneau de configuration du blog</h2>

    <!-- Styliser comme un onglet comme class="homeTab" mais couleur inverse fond bleu titre en blanc --> 
    <p class="pControlPanelPage">Mon Profil</p>

    <article>

    <a href="index.php?action=blogControlPanel" class="homeTab">Accueil</a>

    <a href="index.php?action=blogControlPanelMyProfile" class="myProfileTab">Mon profil</a>

    <a href="index.php?action=blogControlPanelListOfEpisodes" class="episodeListTab">Liste des épisodes</a>

    <a href="index.php?action=blogControlPanelCreateOfEpisode" class="createAnEpisodeTab">Création d'un épisode</a>

    <a href="index.php?action=blogControlPanelComments" class="commentsTab">Commentaires</a>

    <a href="index.php?action=logout" class="logoutTab">Se déconnecter</a>

    </article>

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