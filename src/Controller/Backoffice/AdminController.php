<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\View\View;

class AdminController
{
    private AdminManager $adminManager;
    private View $view;

    public function __construct(AdminManager $adminManager, View $view)
    {
        $this->adminManager = $adminManager;
        $this->view = $view;
    }

    public function displayLogin(): void
    {
        var_dump($_POST);
        $this->view->render(['template' => 'adminloginpage'], 'backoffice');
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
        $this->view->render(['template' => 'blogcontrolpanelpage'], 'backoffice');
    }
    
    public function authcomments():void
    {
        $this->view->render(['template' => 'authcommentspage'], 'backoffice');
    }

}