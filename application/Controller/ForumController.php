<?php

namespace Mini\Controller;

use Mini\Model\DLA;

class ForumController
{

    public function index()
    {
        require_once '_incSession.php';
        $dlaDb = new DLA();

        $forums = $dlaDb->getForums();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/forum/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function comments($forum_id)
    {
        require_once '_incSession.php';

        if (!isset($forum_id) || empty($forum_id)) {
            header('location: ' . URL . 'forum/?dan=Invalid operation.');
        }

        $dlaDb = new DLA();

        $forum = $dlaDb->getForum($forum_id);
        $comments = $dlaDb->getForumComment($forum_id);

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/forum/comments.php';
        require APP . 'view/_templates/footer.php';
    }

}
