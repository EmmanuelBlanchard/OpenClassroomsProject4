<section class="sectionControlPanelCreateOfEpisode">

    <article>

    <a href="index.php?action=blogControlPanel" class="homeTab">Accueil</a>

    <a href="index.php?action=blogControlPanelMyProfile" class="myProfileTab">Mon profil</a>

    <a href="index.php?action=blogControlPanelListOfEpisodes" class="episodeListTab">Liste des épisodes</a>

    <a href="index.php?action=blogControlPanelCreateOfEpisode" class="createAnEpisodeTab">Création d'un épisode</a>

    <a href="index.php?action=blogControlPanelComments" class="commentsTab">Commentaires</a>

    <a href="index.php?action=logout" class="logoutTab">Se déconnecter</a>

    </article>

    <p class="pControlPanelPage"> Création d'un épisode</p>

    <form method="post" action="index.php?action=">
        <p class="loginFormTitle">
            <label for="title">Titre <span>(obligatoire)</span> </label>
            <input id="title" name="title" type="text" value="" size="30" maxlength="245" required>
        </p>
        <p class="loginFormContent">
            <label for="content">Contenu <span>(obligatoire)</span> </label>
            <textarea id="content" name="content"  value="" size="30" maxlength="245"> 
            </textarea>
        </p>
        <p>
            <input type="submit" class="inputTypeSubmitSaveDraft" value="Enregistrer le brouillon" />
        </p>
        <p>
            <input type="submit" class="inputTypeSubmitPreview" value="Prévisualiser" />
        </p>
        <p>
            <input type="submit" class="inputTypeSubmitPublish" value="Publier" />
        </p>
    </form>

</section>