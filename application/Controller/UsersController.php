<?php

namespace Mini\Controller;

use Mini\Libs\Utility;
use Mini\Model\DLA;

class UsersController
{

    public function index()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();
        $util = new Utility();
        $auth_token =  $util->generateToken();

        $sessions = $dlaDb->getSessions();

        if(isset($_POST['session_id'])){
            $students = $dlaDb->getListOfStudents($_POST['session_id']);
        }

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function facilitators()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $facilitators = $dlaDb->getListOfFacilitators();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/facilitators.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addFacilitator()
    {
        require_once '_incSession.php';

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/add_facilitator.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveFacilitator()
    {
        if (isset($_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["gender"], $_POST["phone_number"], $_POST["marital_status"])) {
            $dlaDb = new DLA();
            $util = new Utility();

            $account = $dlaDb->createAccount($_POST["email"], $util->encryptPassword($_POST["password"]));

            if ($account) {
                $insert = $dlaDb->addFacilitator($account, 'FACILITATOR', $_POST["firstname"], $_POST["lastname"], $_POST["othername"], $_POST["gender"], $_POST["marital_status"], $_POST["phone_number"], $_POST["facebook"], $_POST["instagram"], $_POST["twitter"]);

                if ($insert) {
                    header('location: ' . URL . 'users/facilitators?msg=Facilitator details saved successfully.');
                } else {
                    header('location: ' . URL . 'users/addFacilitator?dan=An error occurred, please try again later..');
                }

            } else {
                header('location: ' . URL . 'users/addFacilitator?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'users/facilitators?dan=Invalid Request');
        }
    }

    public function editFacilitator($profile_id)
    {
        require_once '_incSession.php';

        if (!isset($profile_id) || empty($profile_id)) {
            header('location: ' . URL . 'users/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();

        $facilitator = $dlaDb->getFacilitator($profile_id);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/edit_facilitator.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateFacilitator()
    {
        if (isset($_POST["firstname"], $_POST["lastname"], $_POST["gender"], $_POST["phone_number"], $_POST["marital_status"], $_POST["profile_id"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->updateFacilitator($_POST["firstname"], $_POST["lastname"], $_POST["othername"], $_POST["gender"], $_POST["marital_status"], $_POST["phone_number"], $_POST["facebook"], $_POST["instagram"], $_POST["twitter"], $_POST["profile_id"]);

            if ($insert) {
                header('location: ' . URL . 'users/facilitators?msg=Facilitator details updated successfully.');
            } else {
                header('location: ' . URL . 'users/editFacilitator/' . $_POST["profile_id"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'users/facilitators?dan=Invalid Request');
        }
    }

    public function blockUser($user_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->blockUser($user_id);

        if ($delete) {
            header('location: ' . URL . 'users/?msg=User successfully blocked.');
        } else {
            header('location: ' . URL . 'users/?dan=An error occurred, please try again.');
        }
    }

    public function resetPassword($user_id)
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();
        $util = new Utility();

        $auth_token =  $util->generateToken(23);
        $confirm_email_token =  $util->generateToken(23);
        $remember_token =  $util->generateToken(61);

        $delete = $dlaDb->resetUser($auth_token,$confirm_email_token,$remember_token, $user_id);

        if ($delete) {
            //$util->sendMail($user_id, $remember_token);
            header('location: ' . URL . 'users/?msg=Password Reset successfully.');
        } else {
            header('location: ' . URL . 'users/?dan=An error occurred, please try again.');
        }
    }

    public function viewStudentDetail($user_id)
    {
        require_once '_incSession.php';

        if (!isset($user_id) || empty($user_id)) {
            header('location: ' . URL . 'users/?dan=Invalid operation.');
        }

        $dlaDb = new DLA();

        $student = $dlaDb->getStudent($user_id);
        $sessions = $dlaDb->getStudentSessionDetails($user_id);
        $transactions = $dlaDb->getStudentTransactionDetails($user_id);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/user_details.php';
        require APP . 'view/_templates/footer.php';
    }

}
