<section class="sectionControlPanelCreateOfEpisode">
    <h2>Panneau de configuration du blog</h2>
    <p class="createAnEpisodeTitle">Création d'un épisode</p>
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