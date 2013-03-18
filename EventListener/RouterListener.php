<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Jb\SimpleForumBundle\Routing\Matcher;

/**
 * RouterListener is a service called on kernel.request before the framework native RouterListener
 * It manages the matching of dynamic route with forum Category and Topic
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class RouterListener
{
    /**
     * @var Matcher 
     */
    private $matcher;
    
    /**
     * @var RequestContext 
     */
    private $context;
    
    /**
     * @var LoggerInterface 
     */
    private $logger;
    
    /**
     * Constructor
     * 
     * @param Matcher         $matcher the simpleforum dynamic url matcher service
     * @param RequestContext  $context the request context
     * @param LoggerInterface $logger  the monolog logger
     */
    public function __construct(Matcher $matcher, RequestContext $context = null, LoggerInterface $logger = null) 
    {
        $this->matcher = $matcher;
        $this->context = $context;
        $this->logger  = $logger;
    }
    
    /**
     * onKernelRequest called on event kernel.request
     * It called the matcher in order to find a forum category or topic matching the url
     * 
     * @param GetResponseEvent $event the event dispatched on kernel.request
     * @return array|null
     */
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
