<section class="sectionControlPanelCreateOfEpisode">

    <article>

    <a href="index.php?action=blogControlPanel" class="homeTab">Accueil</a>

    <a href="index.php?action=blogControlPanelMyProfile" class="myProfileTab">Mon profil</a>

    <a href="index.php?action=blogControlPanelListOfEpisodes" class="episodeListTab">Liste des épisodes</a>

    <a href="index.php?action=blogControlPanelCreateOfEpisode" class="createAnEpisodeTab">Création d'un épisode</a>

    <a href="index.php?action=blogControlPanelComments" class="commentsTab">Commentaires</a>

    <a href="index.php?action=logout" class="logoutTab">Se déconnecter</a>

    </article>

    <h2>Panneau de configuration du blog</h2>

    <p class="createAnEpisodeTitle"> Création d'un épisode</p>

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
        
        <input type="submit" class="inputTypeSubmitSaveDraft" value="Enregistrer le brouillon" />
        <input type="submit" class="inputTypeSubmitPreview" value="Prévisualiser" />
        <input type="submit" class="inputTypeSubmitPublish" value="Publier" />
        
    </form>

</section>