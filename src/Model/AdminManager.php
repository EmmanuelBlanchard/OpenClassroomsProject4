<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class AdminManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function adminLogin(): int
    {
        return 1;
    }

    public function registrerUser($user)
    {
        $password = $user['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $user['password'] = $hash;

        $sql = 'INSERT INTO Users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)';
        
        $request = $this->database->prepare($sql);

        $request->execute(array(
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'password' => $user['password']
        ));
    }

    public function loginUser($user)
    {
        // Get userEntry from DB
        $userEntry = $this->getUserFromEmail($user['email']);

        // Check if user exists (and early return if not)
        if (!$userEntry) return false;

        // Get password and hash
        $password = $user['password'];
        $hash = $userEntry['password'];

        // Remove hashed password from $userEntry
        unset($userEntry['password']);

        // Add users fullname to $userEntry
        $userEntry['fullname'] = $userEntry['firstname'] . ' ' . $userEntry['lastname'];

        // Verify password
        if (password_verify($password, $hash)) return $userEntry;

        // Otherwise return false
        return false;
    }

    public function getUserFromEmail($email) {
        $sql = 'SELECT Users.*, users_permission,file.thumb,file.image FROM Users
        LEFT JOIN users_permission ON permission_id = users_permission.id
        LEFT JOIN file ON file_id = file.id WHERE email = :email LIMIT 1';

        $request = $this->database->prepare($sql);

        $request->execute(array(
            'email' => $email
        ));

        $result = $request->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function recordLoginAttempt($email)
    {
        # +1 login attempts on every false  password input
        $sql = 'UPDATE Users SET login_attempts = login_attempts + 1 WHERE email = :email ';
        
        $request = $this->database->prepare($sql);

        $result = $request->execute(array(
            'email' => $email
        ));

        return $result;
    }

    public function resetLoginAttempts($email)
    {
        # if login correct reset attempts to 0
        $sql = 'UPDATE Users SET login_attempts = 0 WHERE email =:email';
        
        $request = $this->database->prepare($sql);

        $result = $request->execute(array(
            'email' => $email
        ));

        return $result;
    }

    public function checkLoginAttempts($email)
    {
        # Check login attempts and see if exceeded the amount of false logins
        $sql = 'SELECT login_attempts FROM Users WHERE email = :email';

        $request = $this->database->prepare($sql);

        $request->execute(array(
            'email' => $email
        ));

        if($request->rowCount() > 0) {
            $result = $request->fetch(\PDO::FETCH_ASSOC);
            return $result['login_attempts'];
        }

        return false;
    }

}