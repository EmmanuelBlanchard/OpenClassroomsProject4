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
            <div id="content">
                <div id="adminbar" class="nojq">
                    <div id="toolbar" class="quicklinks" role="navigation" aria-lablel="Barre d'outils">
                        <ul id="admin-bar-root-default" class="ab-top-menu">
                            <li id="admin-bar-menu-toogle" class="menu-pop"></li>
                            <li id="admin-bar-site-name" class="menu-pop">
                                <a class="ab-item" aria-haspopup="true" href="index.php?home">Blog de Jean Forteroche</a>
                            </li>
                            <li id="admin-bar-comments">
                                <a class="ab-item" aria-haspopup="true" href="index.php?action=editComments">
                                    <span class="ab-icon"></span>
                                    <span class="ab-label awaiting-mod pending-count count-0" aria-hidden="true">0</span>
                                    <span class="screen-reader-text comments-in-moderation-text">0 commentaire en modération</span>
                                </a>
                            </li>
                            <li id="admin-bar-new-content">
                                <a class="ab-item" aria-haspopup="true" href="index.php?action=postNew">
                                    <span class="ab-icon"></span>
                                    <span class="ab-label">Créer</span>
                                </a>
                            </li>
                        </ul>
                        <ul id="admin-bar-top-secondary" class="ab-top-secondary ab-top-menu">
                            <li id="admin-bar-my-account" class="menupop with-avatar">
                                <a class="ab-item" aria-haspopup="true" href="index.php?action=blogControlPanelMyProfile">Bonjour, <span class="display-name">Jean Forteroche</span><img alt="" src="https://secure.gravatar.com/avatar/378d2a95f9b1ebd180c282f01137bba8?s=26&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/378d2a95f9b1ebd180c282f01137bba8?s=52&amp;d=mm&amp;r=g 2x" class="avatar avatar-26 photo" loading="lazy" width="26" height="26"></a>
                            </li>
                        </ul>
                    </div>
                    <a class="screen-reader-shortcut" href="index.php?action=logout">Se déconnecter</a>
                </div>
                <div id="body" role="main">
                    <div id="body-content">
                        <div class="wrap">
                            <h1>Tableau de bord</h1>
                            <div id="welcome-panel" class="welcome-panel">
                                <a></a>
                                <div class="welcome-panel-content">
                                    <h2>Bienvenue sur le Blog de Jean Forteroche</h2>
                                    <div class="welcome-panel-column-container">
                                        <div class="welcome-panel-column">
                                            <p class="homeTitle">Accueil</p>

                                            <p class="pControlPanelPage"> Bienvenue dans le panneau de configuration du blog ! </p>

                                            <p class="pControlPanelPage">Actuellement, votre profil est JeanForteroche</p>
                                            <p class="pControlPanelPage">Vous avez créé *** nombres d'épisodes</p>
                                            <p class="pControlPanelPage">Voici la liste des épisodes :</p>
                                            <p class="pControlPanelPage">Il y a actuellement *** commentaires sur le site</p>
                                            <p class="pControlPanelPage">Vous avez *** nombres de commentaires sur le site</p>
                                            <p class="pControlPanelPage">Vous avez accueilli *** visiteurs depuis 1 mois</p>
                                            <p class="pControlPanelPage">Vous avez accueilli *** visiteurs depuis 1 an</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

            <main>
                <?=$content?>
            </main>
        
    </body>
</html>
