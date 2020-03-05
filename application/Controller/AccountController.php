<?php

namespace Mini\Controller;

use Mini\Model\DLA;

class AccountController
{
    public function index()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        if(isset($_POST['session_id'])){
            $accounts = $dlaDb->getAllTransaction($_POST['session_id']);
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/account/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function approvedTransactions()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        if(isset($_POST['session_id'])){
            $accounts = $dlaDb->getAllApprovedTransaction($_POST['session_id']);
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/account/approved.php';
        require APP . 'view/_templates/footer.php';
    }

    public function unapprovedTransactions()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $sessions = $dlaDb->getSessions();

        if(isset($_POST['session_id'])){
            $accounts = $dlaDb->getAllUnapprovedTransaction($_POST['session_id']);
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/account/unapproved.php';
        require APP . 'view/_templates/footer.php';
    }

    public function activateTransaction($id, $page, $user_id){
        require_once '_incSession.php';

        $dlaDb = new DLA();
        $goto_page = ($page == 'u') ? 'unapprovedTransactions' : '';

        $matric_no = $dlaDb->getlastMatricNo()->matric_number;

        $matric_number = intval(substr($matric_no, 3)) + 1;

        $update = $dlaDb->updateProfileMatric('DLA'.$matric_number, $user_id);

        if ($update) {
            $updateStatus = $dlaDb->updateTransactionStatus($id);
            header('location: ' . URL . 'account/'.$goto_page.'?msg=Account approved successfully.');
        } else {
            header('location: ' . URL . 'account/'.$goto_page.'?dan=An error occurred, please try again.');
        }
    }

}
