<?php

namespace Jb\SimpleForumBundle\Routing;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Doctrine\Common\Cache\Cache;

class Matcher
{
    /**
     * @var UrlMatcherChain
     */
    protected $matcherChain;
    
    /**
     * @var Cache
     */
    protected $cache;
    
    /**
     * Constructor.
     *
     * @param UrlMatcherChain  $matcherChain The forum matcher chain
     */
    public function __construct(UrlMatcherChain $matcherChain, Cache $cache = null)
    {
        $this->matcherChain = $matcherChain;
        $this->cache = $cache;
    }
    
    public function match($url) 
    {
        $explodedUrl = array_reverse(array_filter(explode('/', $url)));
        
        if (count($explodedUrl) < 1) {
            throw new ResourceNotFoundException();
        }
        
        if ($this->cache !== null && $this->cache->contains($url)) {
            return unserialize($this->cache->fetch($url));
        }
        
        foreach ($this->matcherChain->getMatchers() as $matcher) {
            $parameter = $matcher->match($explodedUrl);
            if (is_array($parameter)) {
                if ($this->cache !== null) {
                    $this->cache->save($url, serialize($parameter));
                }
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
