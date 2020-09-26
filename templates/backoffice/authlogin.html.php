<?php
    $emailError = isset($this->email_err) ? true : false;
    $emailErrorMsg = isset($this->email_err) ? $this->email_err : '';
?>
<section>
<div class="">
    <div class="">
        <div class="">

            <!-- Error alert -->
            <?php if($emailError) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $emailErrorMsg ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <h2>Connexion</h2>
            <p>Veuillez remplir vos identifiants pour vous connecter</p>
            <form action="index.php?action=doLogin" method="POST">
                <div class="">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" name="email" class=" <?= ($emailError) ? 'is-invalid' : '' ?>">
                </div>         

                <div class="">
                    <label for="name">Mot de passe: <sup>*</sup></label>
                    <input type="password" name="password" class=" <?= ($emailError) ? 'is-invalid' : '' ?>">
                </div>

                <div class="">
                    <div class="">
                        <input type="submit" value="Connexion" class="">
                    </div>
                    <div class="">
                        <a href="index.php?action=register" class="">Pas de compte ? S'inscrire</a>
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>
</section>