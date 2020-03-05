<?php

namespace Mini\Controller;

use Mini\Model\DLA;

class MessageController
{

    public function index()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $messages = $dlaDb->getMyMessages($_SESSION['user_id']);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function student()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/student.php';
        require APP . 'view/_templates/footer.php';
    }


    public function facilitator()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $facilitators = $dlaDb->getFacilitators();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/message/facilitator.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveMessage()
    {
        if (isset($_POST["receiver_id"], $_POST["subject"],$_POST["body"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addMessage($_SESSION['user_id'], $_POST["receiver_id"], $_POST["subject"],$_POST["body"]);

            if ($insert) {
                header('location: ' . URL . 'message/?msg=Message sent successfully.');
            } else {
                header('location: ' . URL . 'message/facilitator?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'message/facilitator?dan=Invalid Request');
        }
    }

    public function getStudentinSession($id)
    {
        $options = '<option value="">-- Select Option --</option>';

        $dlaDb = new DLA();

        $students = $dlaDb->getStudentInSession($id);

        if(count($students)> 0){
            foreach ($students as $student){
                $options .= '<option value="'.$student->user_id.'">'.$student->firstname.' '.$student->lastname .'</option>';
            }
        }

        echo $options;
    }

}
