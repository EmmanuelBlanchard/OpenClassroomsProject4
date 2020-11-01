<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    public static function start(): void
    {
        session_start();
    }

    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    // Essais CRSF
    public function store_in_session($key, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$key]=$value;
        }
    }
    
    public function unset_session($key): void
    {
        $_SESSION[$key]=' ';
        unset($_SESSION[$key]);
    }

    public function get_from_session($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function csrfguard_generate_token($unique_form_name)
    {
        $token = random_bytes(64); // PHP 7, or via paragonie/random_compat
        $this->store_in_session($unique_form_name, $token);
        return $token;
    }

    public function csrfguard_validate_token($unique_form_name, $token_value)
    {
        $token = $this->get_from_session($unique_form_name);
        if (!is_string($token_value)) {
            return false;
        }
        $result = hash_equals($token, $token_value);
        $this->unset_session($unique_form_name);
        return $result;
    }

    public function csrfguard_replace_forms($form_data_html)
    {
        $count=preg_match_all("/<form(.*?)>(.*?)<\\/form>/is", $form_data_html, $matches, PREG_SET_ORDER);
        if (is_array($matches)) {
            foreach ($matches as $m) {
                if (mb_strpos($m[1], "nocsrf")!==false) {
                    continue;
                }
                $name="CSRFGuard_".random_int(0, mt_getrandmax());
                $token= $this->csrfguard_generate_token($name);
                $form_data_html=str_replace(
                    $m[0],
                    "<form{$m[1]}>
    <input type='hidden' name='CSRFName' value='{$name}' />
    <input type='hidden' name='CSRFToken' value='{$token}' />{$m[2]}</form>",
                    $form_data_html
                );
            }
        }
        return $form_data_html;
    }

    public function csrfguard_inject(): void
    {
        $data=ob_get_clean();
        $data= $this->csrfguard_replace_forms($data);
        echo $data;
    }

    public function csrfguard_start(): void
    {
        if (count($_POST)) {
            if (!isset($_POST['CSRFName']) or !isset($_POST['CSRFToken'])) {
                trigger_error("No CSRFName found, probable invalid request.", E_USER_ERROR);
            }
            $name =$_POST['CSRFName'];
            $token=$_POST['CSRFToken'];
            if (!$this->csrfguard_validate_token($name, $token)) {
                throw new \Exception("Invalid CSRF token.");
            }
        }
        ob_start();
        /* adding double quotes for "csrfguard_inject" to prevent:
            Notice: Use of undefined constant csrfguard_inject - assumed 'csrfguard_inject' */
        register_shutdown_function("csrfguard_inject");
    }
    //csrfguard_start();
}
