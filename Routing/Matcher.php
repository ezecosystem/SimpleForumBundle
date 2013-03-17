<?php

namespace Jb\SimpleForumBundle\Routing;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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
    
    public function match($url) 
    {
        $explodedUrl = array_reverse(array_filter(explode('/', $url)));
        
        if (count($explodedUrl) < 1) {
            throw new ResourceNotFoundException();
        }
        
        foreach ($this->matcherChain->getMatchers() as $matcher) {
            $parameter = $matcher->match($explodedUrl);
            if (is_array($parameter)) {
                return $parameter;
            }
        }
        
        throw new ResourceNotFoundException();
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
