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

    public function addRouter(UrlMatcherInterface $matcher )
    {
        $this->matchers[] = $matcher;
    }
}
