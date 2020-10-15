<?php
    if(!isset($_SESSION)) 
    {
        // On demarre la session
        session_start();
    } 
?>

<main class="container">
    <div class="row">
        <section class="col-12">
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
            <h1>Commentaires</h1>
            
            <table class="table">
                <thead>
                    <th>Actions</th>
                </thead>
                <tbody>
                        <tr>
                            <td>
                                <a class="btn btn-primary" href="index.php?action=readComments">Liste des commentaires</a>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="index.php?action=reportedComments">Liste des commentaires signalés</a>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="index.php?action=approvedComments">Liste des Commentaires approuvés</a>
                            </td>
                        </tr>
                </tbody>
            </table>
                <a class="btn btn-primary" href="index.php?action=blogControlPanel">Retour</a>
        </section>
    </div>
</main>