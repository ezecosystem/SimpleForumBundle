<?php

namespace Jb\SimpleForumBundle\Routing;

class Matcher
{
    /**
     * @var UrlMatcherChain
     */
    protected $matcherChain;
    
    /**
     * Constructor.
     *
     * @param UrlMatcherChain  $matcherChain The forum matcher chain
     */
    public function __construct(UrlMatcherChain $matcherChain)
    {
        $this->matcherChain = $matcherChain;
    }
    
    public function match($url) {
        return array(
            '_controller' => 'SimpleForumBundle:Default:show',
            '_route' => 'category'
        );
    }
    
    public function setMatcherChain(UrlMatcherChain $matcherChain) 
    {
        $this->matcherChain = $matcherChain;
    }

    /**
     * {@inheritdoc}
     */
    public function getMatcherChain()
    {
        return $this->matcherChain;
    }
}
