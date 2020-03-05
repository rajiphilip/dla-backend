<?php

namespace Mini\Controller;

use Mini\Model\DLA;
use Mini\Libs\Utility;

class LoginController
{

    public function index()
    {
        // load views
        require APP . 'view/_templates/header_login.php';
        require APP . 'view/login/index.php';
        require APP . 'view/_templates/footer_login.php';
    }

    public function login()
    {
        if (isset($_POST['email'], $_POST['password'])) {
            $dlaDb = new DLA();
            $util = new Utility();
            $user = $dlaDb->getUserByEmail($_POST["email"]);

            if ($user) {
                $valid = $util->verifyPassword($_POST['password'], $user->password);
                if ($valid) {
                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['username'] = $user->email;
                    $_SESSION['fullname'] = $user->firstname . " " . $user->lastname;
                    $_SESSION['role_id'] = $user->role_id;
                    $_SESSION['profile_id'] = $user->profile_id;
                    $_SESSION['type'] = $user->type;

                    header('location: ' . URL);
                } else {
                    header('location: ' . URL . 'login?dan=Invalid username/password.');
                }

            } else {
                header('location: ' . URL . 'login?dan=Account not found or not eligible on this platform.');
            }
        } else {
            header('location: ' . URL . 'login?dan=Invalid request.');
        }
    }
}
