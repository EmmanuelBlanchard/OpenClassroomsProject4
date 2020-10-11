
<div class="wrap">
    <section>
        <h1 class="heading-inline">Création d'un épisode</h1>
        <form method="post" action="index.php?action=postNew">
            <p>
                <label for="title">Titre <span>(obligatoire)</span> </label>
                <input id="title" name="title" type="text" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <label for="chapter">Numéro de l'épisode <span>(obligatoire)</span> </label>
                <input id="chapter" name="chapter" type="number" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <label for="date">Date <span>(obligatoire)</span> </label>
                <input id="date" name="date" type="date" value="" size="30" maxlength="245" required>
            </p>
            <p>
                <label for="content">Contenu de l'épisode <span>(obligatoire)</span> </label>
                <textarea id="content" name="content"  value="" size="60" maxlength="500"> 
                </textarea>
            </p>
            <p>
                <label for="introduction">Introduction de l'épisode <span>(obligatoire)</span> </label>
                <textarea id="introduction" name="introduction"  value="" size="30" maxlength="245"> 
                </textarea>
            </p>
            <p>
                <label for="author">Auteur <span>(obligatoire)</span> </label>
                <input id="author" name="author" type="text" value="" size="30" maxlength="40" required>
            </p>

            <input type="submit" class="button" value="Enregistrer le brouillon" />
            <input type="submit" class="button" value="Prévisualiser" />
            <input type="submit" class="button" value="Publier" />

            <input type="submit" class="button" value="Valider" />
            
        </form>
    </section>
</div>
