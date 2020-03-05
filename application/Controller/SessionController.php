<?php

namespace Mini\Controller;

use Mini\Model\DLA;
use Mini\Libs\Utility;

class SessionController {

    public function index() {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/session/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addSession()
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();
        //$util = new Utility();

        $courses = $dlaDb->getCourses();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/session/add_session.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveSession()
    {
        if (isset($_POST["theme"], $_POST["course_id"], $_POST["status"],$_POST["fee"], $_POST["start_date"], $_POST["end_date"], $_POST["registration_start_date"], $_POST["registration_end_date"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addSession($_POST["status"], $_POST["course_id"], $_POST["start_date"], $_POST["end_date"], $_POST["registration_start_date"], $_POST["registration_end_date"],$_POST["fee"], $_POST["theme"]);

            if ($insert) {
                header('location: ' . URL . 'session/?msg=Session details saved succesfully.');
            } else {
                header('location: ' . URL . 'session/addSession?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'session/addSession?dan=Invalid Request');
        }
    }

    public function editSession($session_id)
    {
        require_once '_incSession.php';

        if (!isset($session_id) || empty($session_id)) {
            header('location: ' . URL . 'session/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();


        $session = $dlaDb->getSession($session_id);
        $courses = $dlaDb->getCourses();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/session/edit_session.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateSession()
    {
        if (isset($_POST["theme"], $_POST["course_id"], $_POST["status"],$_POST["fee"], $_POST["start_date"], $_POST["end_date"], $_POST["registration_start_date"], $_POST["registration_end_date"], $_POST["session_id"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->updateSession($_POST["status"], $_POST["course_id"], $_POST["start_date"], $_POST["end_date"], $_POST["registration_start_date"], $_POST["registration_end_date"],$_POST["fee"], $_POST["theme"], $_POST["session_id"]);

            if ($insert) {
                header('location: ' . URL . 'session/?msg=Session details updated successfully.');
            } else {
                header('location: ' . URL . 'session/editSession/' . $_POST["session_id"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'session/?dan=Invalid Request');
        }
    }

    public function deleteSession($session_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->deleteSession($session_id);

        if ($delete) {
            header('location: ' . URL . 'session/?msg=Session successfully deleted.');
        } else {
            header('location: ' . URL . 'session/?dan=An error occurred, please try again.');
        }
    }
    
   
}
