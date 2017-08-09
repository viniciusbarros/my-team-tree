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

    /**
     * Tries to perform an user authentication
     * 
     * @param type $email
     * @param type $password
     * @return $this
     */
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
     * 
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

    /**
     * Checks weather a raw password and its hashed value match
     *
     * @param string $password
     * @param string $hashed
     * @return boolean
     */
    private function checkPassword($password, $hashed)
    {
        return password_verify($password, $hashed);
    }

    /**
     * Hashes a password
     * 
     * @param string $password
     * @return string
     */
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Set session with authenticated user details
     * 
     * @param User $user
     */
    private function setSession(User $user)
    {
        $_SESSION['auth'] = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'start' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Destroys the session
     */
    public function logout()
    {
        session_destroy();
        $this->authenticated = false;
    }

    /**
     * Returns authentication errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function getAuthenticatedUser()
    {
        $return = [];
        if ($this->isAuthenticated()) {
            return $_SESSION['auth']['user'];
        }
    }
}