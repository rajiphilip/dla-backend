<?php

namespace Mini\Controller;

use Mini\Model\DLA;

class FeedbackController
{

    public function index()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $feedback_questions = $dlaDb->getFeedbackQuestions();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addQuestion()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $feedback_types = $dlaDb->getFeedbackTypes();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/add_question.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveFeedbackQuestion()
    {
        if (isset($_POST["type"], $_POST["question"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addFeedbackQuestion($_POST["type"], $_POST["question"]);

            if ($insert) {
               header('location: ' . URL . 'feedback/?msg=Feedback question saved successfully.');
            } else {
                header('location: ' . URL . 'feedback/addQuestion?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'feedback/addFeedback?dan=Invalid Request');
        }
    }

    public function editQuestion($feedback_id)
    {
        require_once '_incSession.php';

        if (!isset($feedback_id) || empty($feedback_id)) {
            header('location: ' . URL . 'feedback/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();
        $feedback_types = $dlaDb->getFeedbackTypes();
        $feedback = $dlaDb->getFeedbackQuestion($feedback_id);

        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/edit_question.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateFeedbackQuestion()
    {
        if (isset($_POST["type"], $_POST["question"], $_POST["feedback_id"])) {
            $dlaDb = new DLA();


            $insert = $dlaDb->updateFeedbackQuestion($_POST["type"], $_POST["question"], $_POST["feedback_id"]);

            if ($insert) {
                header('location: ' . URL . 'feedback/?msg=Feedback Question updated successfully.');
            } else {
                header('location: ' . URL . 'feedback/editQuestion/' . $_POST["feedback_id"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'feedback/?dan=Invalid Request');
        }
    }

    public function deleteFeedbackQuestion($feedback_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->deleteFeedbackQuestion($feedback_id);

        if ($delete) {
            header('location: ' . URL . 'feedback/?msg=Feedback successfully deleted.');
        } else {
            header('location: ' . URL . 'feedback/?dan=An error occurred, please try again.');
        }
    }

    public function feedbackTypes()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $feedback_types = $dlaDb->getFeedbackTypes();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/feedback_types.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addFeedbackType()
    {
        require_once '_incSession.php';

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/add_feedback_type.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveFeedbackType()
    {
        if (isset($_POST["type"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addFeedbackType($_POST["type"], $_POST["question"]);

            if ($insert) {
                header('location: ' . URL . 'feedback/feedbackTypes?msg=Feedback Type saved successfully.');
            } else {
                header('location: ' . URL . 'feedback/addFeedbackType?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'feedback/addFeedbackType?dan=Invalid Request');
        }
    }

    public function editFeedbackType($feedback_id)
    {
        require_once '_incSession.php';

        if (!isset($feedback_id) || empty($feedback_id)) {
            header('location: ' . URL . 'feedback/feedbackTypes?dan=Invalid operation.');
        }
        $dlaDb = new DLA();

        $feedback = $dlaDb->getFeedbackType($feedback_id);

        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/edit_feedback_type.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateFeedbackType()
    {
        if (isset($_POST["type"], $_POST["feedback_type_id"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->updateFeedbackType($_POST["type"], $_POST["feedback_type_id"]);

            if ($insert) {
                header('location: ' . URL . 'feedback/feedbackTypes?msg=Feedback Type updated successfully.');
            } else {
                header('location: ' . URL . 'feedback/editFeedbackType/' . $_POST["feedbackTypes"] . '?dan=An error occurred, please try again later.');
            }
        } else {
            header('location: ' . URL . 'feedback/feedbackTypes?dan=Invalid Request');
        }
    }

    public function deleteFeedbackType($feedback_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $delete = $dlaDb->deleteFeedbackType($feedback_id);

        if ($delete) {
            header('location: ' . URL . 'feedback/feedbackTypes?msg=Feedback Type successfully deleted.');
        } else {
            header('location: ' . URL . 'feedback/feedbackTypes?dan=An error occurred, please try again.');
        }
    }

    public function viewFeedbacks()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        if(isset($_POST['session_id'], $_POST['facilitator_id'])){
            $feedbacks = $dlaDb->getFeedback($_POST['session_id'], $_POST['facilitator_id']);
        }

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/feedback/view_feedbacks.php';
        require APP . 'view/_templates/footer.php';
    }

    public function getFacilatorsForSession($id)
    {
        $options = '<option value="">-- Select Option --</option>';

        $dlaDb = new DLA();

        $facilitators = $dlaDb->getFacilitatorsInSession($id);

        if(count($facilitators)> 0){
            foreach ($facilitators as $facilitators){
                $options .= '<option value="'.$facilitators->user_id.'">'.$facilitators->firstname.' '.$facilitators->lastname.'</option>';
            }
        }

        echo $options;
    }

}
