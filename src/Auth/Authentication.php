<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Auth;

use MyTeamTree\Model\User;

/**
 * Description of Authentication
 *
 * @author vinicius
 */
class Authentication
{
    protected $authenticated = false;
    protected $errors        = [];

    public function doAuthentication($email, $password)
    {
        $user = User::where('email', $email)->first();
        //Checking if email was found
        if ($user) {

            if ($this->checkPassword($password, $user->password)) {
                $this->authenticated = true;
                $this->setSession($user);
            } else {
                $this->errors[] = "Password doesn't match.";
            }
        } else {
            $this->errors[] = "User not found.";
        }

        return $this;
    }

    /**
     * Checks weather the user is authenticated
     * @return boolean
     */
    public function isAuthenticated()
    {
        if ($this->authenticated ||
            isset($_SESSION['auth']['user'])) {
            $this->authenticated = true;
        }

        return $this->authenticated;
    }

    private function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function setSession(User $user)
    {
        $_SESSION['auth'] = [
            'user' => $user->id,
            'start' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Destroy the session
     */
    public function logout()
    {
        session_destroy();
        $this->authenticated = false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}