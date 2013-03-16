<?php

namespace Jb\SimpleForumBundle\Controller;

class DefaultController {
    public function showAction() {
        return new \Symfony\Component\HttpFoundation\Response('simpleforum_default');
    }
}

?>
