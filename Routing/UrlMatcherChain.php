<?php

namespace Jb\SimpleForumBundle\Routing;

use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class UrlMatcherChain 
{
    private $matchers;

    public function __construct()
    {
        $this->matchers = array();
    }

    public function addMatcher(UrlMatcherInterface $matcher )
    {
        $this->matchers[] = $matcher;
    }
    
    public function getMatchers() 
    {
        return $this->matchers;
    }
}
