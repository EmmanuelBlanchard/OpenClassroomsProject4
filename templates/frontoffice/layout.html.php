<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- La balise title: décrire de manière généraliste le contenu d’un document -->
        <title> Blog de Jean Forteroche, acteur et écrivain</title>
        <!-- La balise meta description permet d’ajouter une description d'une page affichée -->
        <meta name="description" content="Jean Forteroche, acteur et écrivain, écrit actuellement 'Billet simple pour l'Alaska' "/>
        <!-- Balise meta viewport pour contrôler la mise en page sur les navigateurs mobiles -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Appel de la feuille de style -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        <!-- Navigation -->
        <nav id="navBar"> 
            <ul class="menu">
              <li class="logo"><a href="index.php?action=home">Jean Forteroche</a></li>
              <li class="item episodes"><a href="index.php?action=home">Accueil</a></li>
              <li class="item episodes"><a href="index.php?action=listOfPosts">Liste des épisodes</a></li>
              <?php if(!isset($_SESSION['id']) AND !isset($_SESSION['pseudo'])): ?>
                <li class="item button"><a href="index.php?action=login">Connexion</a></li>
              <?php else: ?>
                <li class="item button"><a href="index.php?action=logout">Deconnexion</a></li>
                <li class="item button"><a href="index.php?action=blogControlPanel">Tableau de bord</a></li>
              <?php endif ?>
            </ul>
        </nav>

        <!-- Page Header -->
        <header>
                <h1>"Billet Simple pour l'Alaska" <br> roman en ligne par Jean Forteroche </h1>
                <div class="classImg">
                    <img id="imgHeader" src="./images/image-1920-1080.jpg" alt="Longue route avec rangée d'arbres et au fond, vue de la montagne enneignée" />
                </div>
        </header>

        <main>
            <?=$content?>
        </main>
        
        <footer class="footer text-center">
            <h3>Copyright Emmanuel Blanchard</h3>
            <p>Projet 4 d'Openclassrooms</p>
            <p>Les textes sont issus du roman "De Québec à Victoria" de 
                Adolphe-Basile Routhier</p>
        </footer>     
    </body>
</html>
