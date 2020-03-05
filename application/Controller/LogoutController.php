<?php

namespace Mini\Controller;

class LogoutController {

    public function index() {
        $_SESSION['user_id'] = null;
        $_SESSION['username'] = null;
        $_SESSION['fullname'] = null;
        $_SESSION['role_id'] = null;
        $_SESSION['profile_id'] = null;
        $_SESSION['type'] = null;


        header('location: ' . URL . 'login');
    }

}
