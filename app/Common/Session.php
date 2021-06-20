<?php

namespace App\Common;

use App\Models\User;
use Exception;

class Session
{
    private $curUser = null;

    // Singletone Implementation
    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }

    public function user()
    {
        return $this->curUser;
    }

    public function setUserById($id)
    {
        $this->curUser = User::find($id);
        $_SESSION['curuser'] = $id;
        return $this->curUser;
    }

    public function setUser($user)
    {
        $this->curUser = $user;
        $_SESSION['curuser'] = $this->curUser->id;
        return $user;
    }

    public function unsetUser()
    {
        $this->curUser = null;
        unset($_SESSION['curuser']);
    }

    // Private
    private function __construct()
    {
        if (!isset($_SESSION['curuser']))
            return;
        if (!$_SESSION['curuser'])
            return;

        try {
            $user = User::find($_SESSION['curuser']);
            $this->setUser($user);
        } catch (Exception $e) {
            $this->unsetUser();
            return;
        }
    }
}
