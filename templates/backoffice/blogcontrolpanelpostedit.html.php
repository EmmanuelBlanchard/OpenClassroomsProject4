<div class="wrap">
    <h1 class="heading-inline">Éditer l'épisode</h1>

    <form method="post" action="index.php?action=postEdit">
    
        <p>
            <label for="title">Titre <span>(obligatoire)</span> </label>
            <input id="title" name="title" type="text" value="" size="30" maxlength="245" required>
        </p>
        <p>
            <label for="post-number">Numéro de l'épisode <span>(obligatoire)</span> </label>
            <input id="post-number" name="post-number" type="number" value="" size="30" maxlength="245" required>
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

        <input type="submit" class="button" value="Valider" />
        
    </form>

</div>

