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
        <link rel="stylesheet" type="text/css" href="css/stylebackoffice.css">
    </head>

    <body class="sticky-menu">
        <div id="wrap">
            <div id="adminmenumain" role="navigation" aria-label="Menu Principal">
                <a href="body-content" class="screen-reader-shortcut">Aller au contenu principal</a>
                <a href="toolbar" class="screen-reader-shortcut">Aller à la barre d’outils</a>
            </div>
            <div id="adminmenuback"></div>
            <div id="adminmenuwrap">
                <ul id="adminmenu">
                    <li id="menu-dashboard" class="menu-top has-submenu has-current-submenu">
                        <a class="first-item has-submenu has-current-submenu menu-open menu-top menu-top-first menu-icon-dashboard menu-top-last">
                            <div class="menu-image"></div>
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
                            <div class="menu-image"></div>
                            <div class="menu-name">Mon profil</div>
                        </a>
                    </li>
                    <li class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first">
                        <a href="index.php?action=blogControlPanelListOfEpisodes" class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" aria-haspopup="true">
                            <div class="menu-image"></div>    
                            <div class="menu-name">Liste des épisodes</div>
                        </a>
                    </li>
                    <li class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first">
                        <a href="index.php?action=blogControlPanelCreateOfEpisode" class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" aria-haspopup="true">
                            <div class="menu-image"></div>
                            <div class="menu-name">Création d'un épisode</div>
                        </a>
                    </li>
                    <li class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first">
                        <a href="index.php?action=blogControlPanelComments" class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" aria-haspopup="true">
                            <div class="menu-image"></div>       
                            <div class="menu-name">Commentaires</div>
                        </a>
                    </li>
                    <li class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" class="has-submenu not-current-submenu menu-top menu-icon-post open-if-no-js menu-top-first" aria-haspopup="true">
                        <a href="index.php?action=logout">
                            <div class="menu-image"></div>
                            <div class="menu-name">Se déconnecter</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

            <main>
                <?=$content?>
            </main>
        
    </body>
</html>
