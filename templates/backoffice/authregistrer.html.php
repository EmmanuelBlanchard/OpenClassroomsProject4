<?php 

    $formClass = isset($this->error) ? 'error' : '';

    $firstnameData = isset($this->formData['firstname']) ? $this->formData['firstname'] : '';
    $lastnameData = isset($this->formData['lastname']) ? $this->formData['lastname'] : '';
    $emailData = isset($this->formData['email']) ? $this->formData['email'] : '';
    $passwordData = isset($this->formData['password']) ? $this->formData['password'] : '';
    $confirmPasswordData = isset($this->formData['confirm_data']) ? $this->formData['confirm_data'] : '';
    
    $firstnameErr = isset($this->error['firstname']) ? 'is-invalid' : '';
    $lastNameErr = isset($this->error['lastname']) ? 'is-invalid' : '';
    $emailErr = isset($this->error['email']) ? 'is-invalid' : '';
    $passwordErr = isset($this->error['password']) ? 'is-invalid' : '';
    $confirmPasswordErr = isset($this->error['confirm_password']) ? 'is-invalid' : '';

    $nameErrorMsg = isset($this->error['name_err']) ? $this->error['name_err'] : '';
    $lastNameErrorMsg = isset($this->error['lastname_err']) ? $this->error['lastname_err'] : '';
    $emailErrorMsg = isset($this->error['email_err']) ? $this->error['email_err'] : '';
    $passwordErrorMsg = isset($this->error['password_err']) ? $this->error['password_err'] : '';
    $confirmPasswordErrorMsg = isset($this->error['confirm_password_err']) ? $this->error['confirm_password_err'] : '';

?>

<section>
<div class="">
    <div class="">
        <div class="">
            <h2>Créer un compte</h2>
            <p>Veuillez remplir ce formulaire pour vous inscrire</p>
            <form action="index.php?action=doRegister" method="POST" name="myForm">

                <div class="form-group">
                    <label for="name">Prénom: <sup>*</sup></label>
                    <input type="text" name="firstname" class=" <?= $firstnameErr ?>"  value="<?= $firstnameData ?>">
                    <span class="invalid-feedback"><?= $nameErrorMsg ?></span>
                </div>
 

                <div class="">
                    <label for="name">Nom: <sup>*</sup></label>
                    <input type="text" name="lastname" class=" <?= $lastNameErr ?>"  value="<?= $lastnameData ?>">
                    <span class="invalid-feedback"><?= $lastNameErrorMsg ?></span>
                </div>

                <div class="">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" name="email" class=" <?= $emailErr ?>" value="<?= $emailData ?>">
                    <span class="invalid-feedback"><?= $emailErrorMsg ?></span>
                </div>        
                

                <div class="">
                    <label for="name">Mot de passe: <sup>*</sup></label>
                    <input type="password" name="password" class=" <?= $passwordErr ?>" value="<?= $passwordData ?>">
                    <span class="invalid-feedback"><?= $passwordErrorMsg ?></span>
                </div>

                <div class="">
                    <label for="confirm_password">Confirmer le mot de passe: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class=" <?= $confirmPasswordErr ?>" value="<?= $confirmPasswordData ?>">
                    <span class="invalid-feedback"><?= $confirmPasswordErrorMsg ?></span>
                </div>  

                <div class="">
                    <div class="">
                    <input type="submit" value="S'inscrire" class="">
                    </div>
                    <div class="col">
                    <a href="index.php?action=login" class="">Vous avez un compte ? Connexion</a>
                    </div>
                </div>       
            </form>
        </div>
    </div>
</div>
</section>
<div class=""></div>