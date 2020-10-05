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
    
    public function displayAdmin(): void
    {
        $this->view->render(['template' => 'blogcontrolpanelpage'], 'backoffice');
    }
    
    public function blogControlPanelMyProfile():void
    {
        $this->view->render(['template' => 'blogcontrolpanelmyprofilepage'], 'backoffice');
    }

    public function blogControlPanelListOfEpisodes():void
    {
        $data = $this->adminManager->showAllPosts();
        
        $this->view->render(['template' => 'blogcontrolpanellistofepisodespage', 'allposts' => $data], 'backoffice');
    }

    public function blogControlPanelCreateOfEpisode():void
    {
        $this->view->render(['template' => 'blogcontrolpanelcreateofepisodepage'], 'backoffice');
    }

    public function blogControlPanelComments():void
    {
        $this->view->render(['template' => 'blogcontrolpanelcommentspage'], 'backoffice');
    }

}