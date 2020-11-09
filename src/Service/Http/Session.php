<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    private $session;

    public function __construct()
    {
        if (isset($_SESSION)) {
            session_start();
        }
    }

    public function startSession(): void
    {
        session_start();
    }

    public function setSession($name, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$name] = $value;
        }
    }

    public function getSession($name): ?array
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function showSession($name): ?array
    {
        if (isset($_SESSION[$name])) {
            $key = $this->getSession($name);
            $this->removeSession($name);
            return $key;
        }
    }

    public function removeSession($name): void
    {
        unset($_SESSION[$name]);
    }

    public function stopSession(): void
    {
        $_SESSION = [];
        session_destroy();
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
        $_SESSION['message'] = "Vous êtes maintenant déconnecté !";
        $_SESSION['login'] = false;
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
    }

    /* ESSAI CRSF */
    public function crsfguardGenerateToken($uniqueFormName): string
    {
        $token = random_bytes(78);
        $this->setSession($uniqueFormName, $token);
        return $token;
    }

    public function crsfguardValidateToken($uniqueFormName, $tokenValue): bool
    {
        $token = $this->getSession($uniqueFormName);
        if (!is_string($tokenValue)) {
            return false;
        }
        $result = hash_equals($token, $tokenValue);
        $this->removeSession($uniqueFormName);
        return $result;
    }

    public function crsfguardReplaceForms($formDataHtml): bool
    {
        $count = preg_match_all("/<form(.*?)>(.*?)<\\/form>/is", $formDataHtml, $matches, PREG_SET_ORDER);
        if (is_array($matches)) {
            foreach ($matches as $m) {
                if (mb_strpos($m[1], "nocsrf") !==false) {
                    continue;
                }
                $name = "CRSFGuard_".random_int(0, mt_getrandmax());
                $token = $this->crsfguardGenerateToken($name);
                $formDataHtml = str_replace(
                    $m[0],
                    "<form{$m[1]}>
                    <input type='hidden' name='CRSFName' value='{$name}' />
                    <input type='hidden' name='CRSFToken' value='{$token}' />{$m[2]}</form>",
                    $formDataHtml
                );
            }
        }
        return $formDataHtml;
    }

    public function crsfguardInject(): void
    {
        $data= ob_get_clean();
        $data= $this->crsfguardReplaceForms($data);
        echo $data;
    }

    public function crsfguardStart(): void
    {
        if (count($_POST)) {
            if (!isset($_POST['CRSFName']) or !isset($_POST['CRSFToken'])) {
                trigger_error("No CRSFName found, probable invalid request.", E_USER_ERROR);
            }
            $name = $_POST['CRSFName'];
            $token = $_POST['CRSFToken'];
            if (!$this->crsfguardValidateToken($name, $token)) {
                throw new \Exception("Invalid CRSF token.");
            }
        }
        ob_start();
        register_shutdown_function("crsfguardInject");
    }
}
