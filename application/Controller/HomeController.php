<?php

namespace Mini\Controller;



class HomeController {

    public function index() {
         require_once '_incSession.php';

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
   
}
