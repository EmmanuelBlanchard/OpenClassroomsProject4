<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Controller\Backoffice\AdminController;
use App\Service\Http\Request;
use App\Service\Http\Session;

class Token
{
    private $token;
    private Session $session;
    private Request $request;

    public function __construct($session)
    {
        //echo '<pre>';
        //var_dump($session);
        //die();
        //echo '</pre>';

        $this->csrfguardGenerateToken($session);
        //var_dump($session);
        //die();
        // object(App\Service\Http\Session)#6 (0) { ["session":"App\Service\Http\Session":private]=> uninitialized(array) }
    }
    // Essais CSRF
    public function storeInSession($key, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$key]=$value;
        }
    }
 
    public function unsetSession($key): void
    {
        $_SESSION[$key]=' ';
        unset($_SESSION[$key]);
    }
 
    public function getFromSession($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }
 
    public function csrfguardGenerateToken($uniqueFormName)
    {
        $token = random_bytes(64); // PHP 7, or via paragonie/random_compat
        $this->storeInSession($uniqueFormName, $token);
        return $token;
    }
 
    public function csrfguardValidateToken($uniqueFormName, $tokenValue)
    {
        $token = $this->getFromSession($uniqueFormName);
        if (!is_string($tokenValue)) {
            return false;
        }
        $result = hash_equals($token, $tokenValue);
        $this->unsetSession($uniqueFormName);
        return $result;
    }
    /*
    public function csrfguard_replace_forms($form_data_html)
    {
        $count=preg_match_all("/<form(.*?)>(.*?)<\\/form>/is",$form_data_html,$matches,PREG_SET_ORDER);
        if (is_array($matches))
        {
            foreach ($matches as $m)
            {
                if (strpos($m[1],"nocsrf")!==false) { continue; }
                $name="CSRFGuard_".mt_rand(0,mt_getrandmax());
                $token= $this->csrfguard_generate_token($name);
                $form_data_html=str_replace($m[0],
                    "<form{$m[1]}>
    <input type='hidden' name='CSRFName' value='{$name}' />
    <input type='hidden' name='CSRFToken' value='{$token}' />{$m[2]}</form>",$form_data_html);
            }
        }
        return $form_data_html;
    }

    public function csrfguard_inject()
    {
        $data=ob_get_clean();
        $data= $this->csrfguard_replace_forms($data);
        echo $data;
    }

    public function csrfguard_start()
    {
        if (count($_POST))
        {
            if ( !isset($_POST['CSRFName']) or !isset($_POST['CSRFToken']) )
            {
                trigger_error("No CSRFName found, probable invalid request.",E_USER_ERROR);
            }
            $name =$_POST['CSRFName'];
            $token=$_POST['CSRFToken'];
            if (!$this->csrfguard_validate_token($name, $token))
            {
                throw new \Exception("Invalid CSRF token.");
            }
        }
        ob_start();
        // adding double quotes for "csrfguard_inject" to prevent:
        //  Notice: Use of undefined constant csrfguard_inject - assumed 'csrfguard_inject'
        register_shutdown_function("csrfguard_inject");
    }
    //$this->csrfguard_start();
  */
}
