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
              <li class="item button"><a href="index.php?action=login">Connexion</a></li>
            </ul>
        </nav>

        <div id="adminmenuwrap">
            <ul id="adminmenu">
                <li id="menu-dashboard" class="menu-top has-submenu has-current-submenu">
                    <a>
                        <div class="menu-name">Tableau de bord</div>
                    </a>
                    <ul class="submenu submenu-wrap">
                        <li class="first-item current">
                            <a class="first-item current" href="">Accueil</a> 
                        </li>
                    </ul>
                </li>
                <li class="not-current-submenu menu-separator" aria-hidden="true">
                    <div class="separator">
                    </div>
                </li>

                <li class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" id="menu-posts">
                    <a href="index.php?action=blogControlPanelMyProfile" class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" aria-haspopup="true">        
                        <div class="menu-name">Mon profil</div>
                    </a>
                </li>
                <li>
                    <a href="index.php?action=blogControlPanelListOfEpisodes">
                        <div>Liste des épisodes</div>
                    </a>
                </li>
                <li>
                    <a href="index.php?action=blogControlPanelCreateOfEpisode">
                        <div>Création d'un épisode</div>
                    </a>
                </li>
                <li>
                    <a href="index.php?action=blogControlPanelComments">
                        <div>Commentaires</div>
                    </a>
                </li>
                <li>
                    <a href="index.php?action=logout">
                        <div>Se déconnecter</div>
                    </a>
                </li>
            </ul>
        </div>
        
        <main>
            <?=$content?>
        </main>
          
    </body>
</html>
