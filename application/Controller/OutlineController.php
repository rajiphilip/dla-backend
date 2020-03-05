<?php

namespace Mini\Controller;

use Mini\Model\DLA;
use Mini\Libs\Utility;

class OutlineController {

    public function index() {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $outlines = $dlaDb->getOutlines();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addOutline()
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();
        //$util = new Utility();

        //$courses = $dlaDb->getCourses();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/add_outline.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveOutline()
    {
        if (isset($_POST["name"], $_POST["description"])) {
            $dlaDb = new DLA();
            $util = new Utility();

            $code = $util->generate_random_string(4);

            $insert = $dlaDb->addOutline($_POST["name"], $_POST["name"].'-'. $code , $_POST["description"]);

            if ($insert) {
                header('location: ' . URL . 'outline/?msg=Outline details saved succesfully.');
            } else {
                header('location: ' . URL . 'outline/addOutline?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'outline/addOutline?dan=Invalid Request');
        }
    }

    public function editOutline($outline_id)
    {
        require_once '_incSession.php';

        if (!isset($outline_id) || empty($outline_id)) {
            header('location: ' . URL . 'outline/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();


        $outline = $dlaDb->getOutline($outline_id);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/edit_outline.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateOutline(){
        if (isset($_POST["name"], $_POST["description"])) {
            $dlaDb = new DLA();
            $util = new Utility();

            $code = $util->generate_random_string(4);

            $insert = $dlaDb->updateOutline($_POST["name"], $_POST["name"].'-'. $code , $_POST["description"], $_POST["outline_id"]);

            if ($insert) {
                header('location: ' . URL . 'outline/?msg=Outline details updated successfully.');
            } else {
                header('location: ' . URL . 'outline/editOutline/' . $_POST["outline_id"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'outline/?dan=Invalid Request');
        }
    }

    public function deleteOutline($outline_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->deleteOutline($outline_id);

        if ($delete) {
            header('location: ' . URL . 'outline/?msg=Outline successfully deleted.');
        } else {
            header('location: ' . URL . 'outline/?dan=An error occurred, please try again.');
        }
    }

    public function viewOutlineTimeTable() {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();
        if(isset($_POST['session_id'])){
            $outlines = $dlaDb->getOutlinesTimeTable($_POST['session_id']);
        }

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/outline_time_table.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addOutlineTimeTable()
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();
        //$util = new Utility();
        $sessions = $dlaDb->getActiveSessions();
        $facilitators = $dlaDb->getFacilitators();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/add_session_time_table.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveOutlineTimeTable()
    {
        if (isset($_POST["session_id"], $_POST["facilitator_id"],$_POST["outline_id"], $_POST["date"],$_POST["start_time"], $_POST["end_time"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addOutlineTimeTable($_POST["session_id"], $_POST["facilitator_id"],$_POST["outline_id"], $_POST["date"],$_POST["start_time"], $_POST["end_time"]);

            if ($insert) {
                header('location: ' . URL . 'outline/viewOutlineTimeTable?msg=Outline Time Table saved succesfully.');
            } else {
                header('location: ' . URL . 'outline/addOutlineTimeTable?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'outline/addOutlineTimeTable?dan=Invalid Request');
        }
    }

    public function editOutlineTimeTable($id)
    {
        require_once '_incSession.php';

        if (!isset($id) || empty($id)) {
            header('location: ' . URL . 'outline/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();

        $outline_timetable = $dlaDb->getOutlineTimeTable($id);
        $sessions = $dlaDb->getSessions();
        $facilitators = $dlaDb->getFacilitators();
        $outlines = $dlaDb->getSessionRemOutline($id);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/outline/edit_session_time_table.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateOutlineTimeTable(){
        if (isset($_POST["session_id"], $_POST["facilitator_id"],$_POST["outline_id"], $_POST["date"],$_POST["start_time"], $_POST["end_time"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->updateOutlineTimeTable($_POST["session_id"], $_POST["facilitator_id"],$_POST["outline_id"], $_POST["date"],$_POST["start_time"], $_POST["end_time"], $_POST["fso_id"]);

            if ($insert) {
                header('location: ' . URL . 'outline/viewOutlineTimeTable?msg=Outline Time Table updated successfully.');
            } else {
                header('location: ' . URL . 'outline/editOutlineTimeTable/' . $_POST["fso_id"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'outline/viewOutlineTimeTable?dan=Invalid Request');
        }
    }

    public function deleteOutlineTimeTable($id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->deleteOutlineTimeTable($id);

        if ($delete) {
            header('location: ' . URL . 'outline/viewOutlineTimeTable/?msg=Outline Time Table successfully deleted.');
        } else {
            header('location: ' . URL . 'outline/viewOutlineTimeTable/?dan=An error occurred, please try again.');
        }
    }

    public function getOutlineTimeTable($id)
    {
        $options = '<option value="">-- Select Option --</option>';

        $dlaDb = new DLA();

        $outlines = $dlaDb->getSessionRemOutline($id);

        if(count($outlines)> 0){
            foreach ($outlines as $outline){
                $options .= '<option value="'.$outline->id.'">'.$outline->name.'</option>';
            }
        }

        echo $options;
    }
}
