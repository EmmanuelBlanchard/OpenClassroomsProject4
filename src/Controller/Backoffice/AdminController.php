<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\View\View;
use App\Service\Http\Session;

define('MAXIMUM_LOGINS', 3);

class AdminController
{
    private AdminManager $adminManager;
    private View $view;
    private Session $session;

    public function __construct(AdminManager $adminManager, View $view)
    {
        $this->adminManager = $adminManager;
        $this->view = $view;
    }

    public function displayLogin(): void
    {
        $this->view->renderBack(['template' => 'adminloginpage']);
    }

    // Example https://github.com/danielzeitler/PHP-MVC-Blog/ Reflexion, comprendre la logique et faire marcher ceci
    public function doRegistrer()
    {
        // Get credentials from POST
        $user = $_POST;

        // Get user by Mail
        $userEntry = $this->adminManager->getUserFromEmail($user['email']);

        // Save all emails
        $error = array();
        
        // Validate Email
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email_err'] = 'Courrier non valide ';
        }

        // Check if Mail already exits
        if($userEntry) {
            $error['email_err'] = 'Le courrier électronique existe déjà';
        }

        // Validate Name
        if(empty($user['firstname'])){
            $error['email_err'] = 'Veuillez entrer votre prénom';
        }

        // Validate Last Name
        if(empty($user['lastname'])){
            $error['email_err'] = 'Veuillez entrer votre nom';
        }

        // Validate Password
        // Mot de passe de 20 caractères dans un alphabet de 90 symboles
        // 90 symboles 9, A à Z, a à z et  ! #$*% ? &[|]@^µ§ :/ ;.,<>°²³
        if(empty($user['password'])){
            $error['password_err'] = 'Veuillez entrer le mot de passe';
        } elseif(strlen($user['password']) < 20){
            $error['password_err'] = 'Le mot de passe doit comporter au moins 20 caractères';
        }

        // Validate Confirm Password
        if(empty($user['confirm_pas_password'])){
            $error['confirm_password_err'] = 'Veuillez confirmer le mot de passe';
        } else {
            if($user['password'] != $user['confirm_password']){
                $error['confirm_password_err'] = 'Les mots de passe ne correspondent pas';
            }
        }

        // Check for error - if no error registrer
        if($error) {
            $this->view->error = $error;
            $this->view->formData = $user;

            $this->view->renderBack(['template' => 'authregistrer']);
        } else {
            MessageController::add('Vous êtes inscrit et vous pouvez maintenant vous connecter');

            $this->adminManager->registrerUser($user);

            // Change location (goto login)
            header('Location: index.php?action=login');
            exit();
        }

    }

    public function doLogin() {
        // Get credentials from POST
        $user = $_POST;

        // Init data
        $user['email'] = trim ($user['email']);
        $user['password'] = trim($user['password']);

        // Empty check
        if(empty($user['email']) || empty($user['password'])) {
            $this->view->email_err = 'Remplir le formulaire serait un bon début';
            return $this->login();
        }

        //Adds +1 to the login attempts if login is false
        $this->adminManager->recordLoginAttempt($user['email']);

        // Get User Entry, Check if exists & Verify Password
        $userEntry = $this->adminManager->loginUser($user);

        // Checking user entry + attempted logins
        if($userEntry && $userEntry['login_attemps'] < MAXIMUM_LOGINS) {
            Session::set('user', $userEntry);
            Session::set('user_image', $userEntry('image'));

            //Reset login attemps to 0 if login succesfuul
            $resetAttempts = $this->adminManager->resetLoginAttempts($user['email']);
            header('Location: index.php?action=home');
            exit();
        }

        // Gets the attempted logins from the Database
        $checkLoginAttempts = $this->adminManager->checkLoginAttempts($user['email']);

        // Check if login Attemps exceeded max logins.
        if($checkLoginAttempts >= MAXIMUM_LOGINS) {
            $this->view->email_err = 'Contactez l\'administrateur. Vous êtes bloqué.';
            return $this->login();
        }

        $this->view->email_err = 'Nom d\'utilisateur ou mot de passe incorrect.';
        $this->login();
    }

    public function logout(): void
    {
        // Remove userEntry from Session
        Session::remove('user');
        session_destroy();

        //Change location (goto home)
        header('Location: index.php?action=home');
        exit();
    }

    # ****************
    # Render functions
    # ****************

    public function login(): void
    {
        $this->view->renderBack(['template' => 'authlogin']);
    }

    public function registrer(): void
    {
        $this->view->renderBack(['template' => 'authregistrer']);
    }

    public function authcomments():void
    {
        $this->view->renderBack(['template' => 'authcommentspage']);
    }

    public function displayLoginAdmin(array $data): void
    {
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] == "JeanForteroche" && $data('password') == "motdepasse" ) {
            $this->adminManager->adminLogin(htmlspecialchars($data['pseudo']), htmlspecialchars($data['password']));

            // Creation du champ password_hash dans la DB ?
            // https://www.php.net/manual/fr/faq.passwords.php
            // https://www.php.net/manual/fr/function.password-hash.php
            // https://www.php.net/manual/fr/function.password-verify.php
            // https://www.php.net/manual/fr/book.password.php
            
            // Verification de la valeur pseudo et du password
            // Hachage et salage du mot de passe puis comparaison
            // password_hash ( string $password , int $algo [, array $options ] ) : string


        } else {
            header('Location: index.php?action=error');
            exit();
        }
        // Redirection vers page d'administration
        header('Location: index.php?action=blogControlPanel'); 
        exit();
    }
    
    public function displayAdmin(): void
    {
        $this->view->renderBack(['template' => 'blogcontrolpanelpage']);
    }
    
    public function displayAdminSetNewPassword(): void
    {
        $this->view->renderBack(['template' => 'adminsetnewpassword']);
    }

}