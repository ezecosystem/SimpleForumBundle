<?php

namespace Jb\SimpleForumBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class ForumRouterListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        
        $request = $event->getRequest();
        
        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }
        
        $request->attributes->add(array(
            '_controller' => 'SimpleForumBundle:Default:show',
            '_route' => 'simpleforum_dynamic_route'
        ));
    }
}

?>
