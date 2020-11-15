<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Controller\Backoffice\AdminController;
use App\Service\Http\Request;
use App\Service\Http\Session;

class Token
{
    private array $token;
    //private array $session;
    private Request $request;

    /**
     * @var array<mixed> Php session data from superglobal.
     */
    private array $session;

    /**
     * @var int Max number of tokens stored in session.
     */
    private int $maxStorage;

    /**
     * @var int Rapresent the lenght of the token in bytes.
     */
    private int $tokenStrength;

    /**
     * Class constructor.
     *
     * @param int $maxStorage    Max number of tokens stored in session, work as
     *                           FIFO data structure, when maximun capacity is
     *                           reached, oldest token be dequeued from storage.
     * @param int $tokenStrength Rapresent the lenght of the token in bytes.
     *
     * @throws RuntimeException  If instance is created without start session
     *                           before and if token strenght parameter is
     *                           less than 16
     */
    public function __construct(int $maxStorage, int $tokenStrength, $session)
    {
        if (\session_status() === 1) {
            //throw new RuntimeException('Session must be started before create instance.');
            $session->setSession('erreur', 'La session doit être lancée avant de créer l\'instance.');
        }

        if ($tokenStrength < 16) {
            //throw new RuntimeException('The minimum CSRF token strength is 16.');
            $session->setSession('erreur', 'Le nombre minimum de jetons du CSRF est de 16.');
        }

        $_SESSION['CSRF'] = $_SESSION['CSRF'] ?? [];

        $this->session = &$_SESSION;
        $this->maxStorage = $maxStorage;
        $this->tokenStrength = $tokenStrength;
    }
    /*
    public function __construct()
    {
        //echo '<pre>';
        //var_dump($session);
        //die();
        //echo '</pre>';


        //var_dump($session);
        //die();
        // object(App\Service\Http\Session)#6 (0) { ["session":"App\Service\Http\Session":private]=> uninitialized(array) }
    }
    */

    /**
     * Limit number of token stored in session.
     *
     * @param array<mixed> $array
     */
    private function dequeue(array &$array): void
    {
        $size = \count($array);

        while ($size > $this->maxStorage) {
            \array_shift($array);
            $size--;
        }
    }

    /**
     * Return csrf token as array.
     *
     * @return array<mixed>
     */
    public function getToken(): array
    {
        $token = $this->generateToken();

        $name = $token['name'];

        $this->session['CSRF'][$name] = $token;

        //storage cleaning!
        //warning!! if you get in a page more token of maximun storage,
        //will there a leak of token, the firsts generated
        //in future I think throw and exception.
        $this->dequeue($this->session['CSRF']);

        return $token;
    }

    /**
     * Return timed csrf token as array.
     *
     * @param int $ttl Time to live for the token.
     *
     * @return array<mixed>
     */
    public function getTimedToken(int $ttl): array
    {
        $token = $this->generateToken();
        $token['time'] = \time() + $ttl;

        $name = $token['name'];

        $this->session['CSRF'][$name] = $token;

        $this->dequeue($this->session['CSRF']);

        return $token;
    }

    /**
     * Generate a random token.
     *
     * @return array<mixed>
     */
    private function generateToken(): array
    {
        $name = 'csrf_'.\bin2hex(\random_bytes(8));
        $value = \bin2hex(\random_bytes($this->tokenStrength));

        return ['name' => $name, 'value' => $value];
    }

    /**
     * Validate a csrf token or a csrf timed token.
     *
     * @param array<mixed> $requestData From request or from superglobal variables $_POST,
     *                                  $_GET, $_REQUEST and $_COOKIE.
     *
     * @return bool
     */
    public function validate(array $requestData): bool
    {
        //apply matchToken method elements of passed data,
        //using this instead of forach for code shortness.
        $array = \array_filter($requestData, [$this, 'doChecks'], ARRAY_FILTER_USE_BOTH);

        return (bool) \count($array);
    }

    /**
     * Tests for valid token.
     *
     * @param string $value
     * @param string $key
     *
     * @return bool
     */
    private function doChecks(string $value, string $key): bool
    {
        $tokens = &$this->session['CSRF'];

        return $this->tokenIsValid($tokens, $value, $key) &&
               $this->tokenIsExiperd($tokens, $key)  &&
               $this->deleteToken($tokens, $key);
    }

    /**
     * Delete token after validation.
     *
     * @param array<mixed>  $tokens
     * @param string        $key
     *
     * @return bool
     */
    private function deleteToken(array &$tokens, string &$key): bool
    {
        unset($tokens[$key]);

        return true;
    }

    /**
     * Check if token is valid
     *
     * @param array<mixed>  $tokens
     * @param string        $value
     * @param string        $key
     *
     * @return bool
     */
    private function tokenIsValid(array &$tokens, string &$value, string &$key): bool
    {
        //if token is not existed
        if (empty($tokens[$key])) {
            return false;
        }

        return \hash_equals($tokens[$key]['value'], $value);
    }

    /**
     * Check if timed token is expired.
     *
     * @param array<mixed>  $tokens
     * @param string        $key
     *
     * @return bool
     */
    private function tokenIsExiperd(array &$tokens, string &$key): bool
    {
        //if timed and if time is valid
        if (isset($tokens[$key]['time']) && $tokens[$key]['time'] < \time()) {
            return false;
        }

        return true;
    }

    /**
     * Clean CSRF storage when full.
     *
     * @param int $preserve Token that will be preserved.
     */
    public function garbageCollector(int $preserve, array $session): void
    {
        if ($this->maxStorage === \count($this->session['CSRF'])) {
            $this->cleanStorage($preserve, $session);
        }
    }

    /**
     * Clean CSRF storage.
     *
     * @param int $preserve Token that will be preserved.
     */
    public function clean(int $preserve, array $session): void
    {
        $this->cleanStorage($preserve, $session);
    }

    /**
     * Do the CSRF storage cleand.
     *
     * @param int $preserve Token that will be preserved.
     *
     * @throws InvalidArgumentException If arguments lesser than 0 or grater than max storage value.
     */
    private function cleanStorage(int $preserve, $session): void
    {
        if ($preserve < 0) {
            //throw new InvalidArgumentException('Argument value should be grater than zero.');
            $session->setSession('erreur', 'La valeur de l\'argument doit être supérieure à zéro.');
        }

        if ($preserve > $this->maxStorage) {
            //throw new InvalidArgumentException("Argument value should be lesser than max storage value ({$this->maxStorage}).");
            $session->setSession('erreur', "La valeur de l\'argument doit être inférieure à la valeur maximale de stockage ({$this->maxStorage}).");
        }

        $tokens = &$this->session['CSRF'];
        $tokens = \array_splice($tokens, -$preserve);
    }


    // Essais CSRF
    /*
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
    */
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
