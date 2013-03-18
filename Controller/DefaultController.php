<?php

namespace Jb\SimpleForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function showAction() {
        //serialize($this->getRequest()->get('entity'));
        return new \Symfony\Component\HttpFoundation\Response('simpleforum_default');
    }
}

?>
