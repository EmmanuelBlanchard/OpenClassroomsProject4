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

    public function login(array $data): void
    {
        //var_dump($_POST);
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] === "JeanForteroche" && $data['password'] === "motdepasse") {
            header('Location: index.php?action=blogControlPanel');
            exit();
        } else {
            $this->view->render(['template' => 'adminloginpage'], 'backoffice');
        }

    }

    public function displayLoginAdmin(array $data): void
    {
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] == "JeanForteroche" && $data['password'] == "motdepasse" ) {
            $this->adminManager->adminLogin(htmlspecialchars($data['pseudo']), htmlspecialchars($data['password']));
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
    
    public function blogControlPanelComments():void
    {
        $this->view->render(['template' => 'blogcontrolpanelcommentspage'], 'backoffice');
    }

}