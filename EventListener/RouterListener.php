<?php

namespace Jb\SimpleForumBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Jb\SimpleForumBundle\Routing\Matcher;

class RouterListener
{
    private $matcher;
    private $context;
    private $logger;
    
    public function __construct(Matcher $matcher, RequestContext $context = null, LoggerInterface $logger = null) 
    {
        $this->matcher = $matcher;
        $this->context = $context;
        $this->logger  = $logger;
    }
    
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
        
        try {
            $parameters = $this->matcher->match($request->getPathInfo());

            if (null !== $this->logger) {
                $this->logger->info(sprintf('Matched route "%s"', $parameters['_route']));
            }
            
            $request->attributes->add($parameters);
            unset($parameters['_route']);
            unset($parameters['_controller']);
            $request->attributes->set('_route_params', $parameters);
            
        } catch (ResourceNotFoundException $e) {
            return;
        }
    }
}
