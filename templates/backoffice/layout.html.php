<?php
    if(!isset($_SESSION)) 
    {
        // On demarre la session
        session_start();
    }
    //On génére un jeton
    $token = uniqid(rand(), true);
    //Et on le stocke
    $_SESSION['token'] = $token;
    //On enregistre aussi le timestamp correspondant au moment de la création du token
    $_SESSION['token_time'] = time();
    //echo '<pre>';
    //var_dump($_SESSION['token'], $_SESSION['token_time']);
    //die();
    //echo '</pre>';
?>
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
        
        <!--  Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!--  Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
        <!-- Appel de la feuille de style -->
        <link rel="stylesheet" type="text/css" href="css/stylebackoffice.css">

        <script src="js/tinymce.min.js"></script>
        <script>tinymce.init({ 
            selector:'textarea', 
            language: 'fr_FR', 
            doctype : '<!DOCTYPE html>', 
            element_format : 'html', 
            mode : "textareas", 
            entity_encoding : 'raw', 
            valid_elements : "em/i,strike,u,span[!style],strong/b,div[align],br,#p[align],-ol[type|compact],-ul[type|compact],-li", 
            protect: [
                /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                /<\?php.*?\?>/g  // Protect php code
            ]
             });</script>
    </head>

    <body>
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php?home">Blog de Jean Forteroche</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <input class="form-control form-control-dark w-100" type="text" placeholder="Rechercher" aria-label="Rechercher">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                <a class="nav-link" href="index.php?action=logout">Se déconnecter</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php?action=blogControlPanel">
                                <span data-feather="home"></span>
                                Tableau de bord <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=myProfile">
                                <span data-feather=""></span>
                                Mon profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=readEpisodes">
                                <span data-feather=""></span>
                                Liste des épisodes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=addEpisode">
                                <span data-feather=""></span>
                                Ajouter un épisode
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=readComments">
                                <span data-feather="message-square"></span>
                                Commentaires
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=reportedComments">
                                <span data-feather=""></span>
                                Commentaires signalés
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Tableau de bord</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar"></span>
                                This week
                            </button>
                        </div>
                    </div>
                    
                    <div class="container"><!--
                    <div class="container-fluid">-->
                        <?=$content?>
                    </div>

                </main>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="dashboard.js"></script>

    </body>

</html>