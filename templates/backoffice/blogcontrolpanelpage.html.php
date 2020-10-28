<div class="wrap">
    <h1>Tableau de bord</h1>
    <div id="welcome-panel" class="welcome-panel">
        <div class="welcome-panel-content">
            <h2>Bienvenue sur le Blog de Jean Forteroche</h2>
            <?php
                if(!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">
                            '. $_SESSION['erreur'].'
                        </div>';
                    $_SESSION['erreur'] = "";
                } 
            ?>
            <?php
                if(!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success" role="alert">
                            '. $_SESSION['message'].'
                        </div>';
                        $_SESSION['message'] = "";
                }
            ?>
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