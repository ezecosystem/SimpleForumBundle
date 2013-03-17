<?php

namespace Jb\SimpleForumBundle\Routing\Route;

use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

class TopicRoute implements UrlMatcherInterface
{
    /**
     * @var RequestContext
     */
    protected $context;
    
    /**
     * Constructor.
     *
     * @param RequestContext  $context The context
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }
    
    public function match($pathinfo) {
    }
    
    public function setContext(RequestContext $context) {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->context;
    }
}
