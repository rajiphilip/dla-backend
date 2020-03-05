<?php

namespace Mini\Controller;

use Mini\Model\DLA;
use Mini\Libs\Utility;

class ResetPasswordController {

    public function index() {
        // load views
        require APP . 'view/_templates/header_login.php';
        require APP . 'view/reset_password/index.php';
        require APP . 'view/_templates/footer_login.php';
    }
    
     public function reset() {
        if (isset($_POST['email'])) {
            $dlaDb = new DLA();
            $util = new Utility();
            
            $new_password = $util->generate_random_string(8);
            // do login() in model/user_model.php
            $user = $dlaDb->resetPassword($_POST["email"], $util->encryptPassword($new_password));

            if ($user) {
                $message = "Your new password is $new_password";
                //Send new password to $email
                $util->sendGenericMail($_POST['email'], $message);
                header('location: ' . URL . 'resetPassword?msg=A new password has been generated and sent to your email.');
            } else {
                header('location: ' . URL . 'resetPassword?dan=Invalid username/password.');
            }
        } else {
            header('location: ' . URL . 'resetPassword?dan=Invalid request.');
        }
    }
}
