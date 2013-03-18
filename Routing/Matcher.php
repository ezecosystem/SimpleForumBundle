<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\Routing;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Doctrine\Common\Cache\Cache;

/**
 * Matcher is the service used for dynamic routing in this bundle
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
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
     * @param Cache            $cache        A cache mecanism provider for caching url matching 
     */
    public function __construct(UrlMatcherChain $matcherChain, Cache $cache = null)
    {
        $this->matcherChain = $matcherChain;
        $this->cache = $cache;
    }
    
    /**
     * Match the url with simpleforum dynamic route
     * 
     * @param string $url the url requested
     * @return bool|array
     * @throws ResourceNotFoundException
     */
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
    
    /**
     * Set the simpleforum matcher chain service
     * 
     * @param UrlMatcherChain $matcherChain the matcher chain service
     */
    public function setMatcherChain(UrlMatcherChain $matcherChain) 
    {
        $this->matcherChain = $matcherChain;
    }

    /**
     * Get the simpleforum matcher chain service
     * 
     * @return UrlMatcherChain
     */
    public function getMatcherChain()
    {
        return $this->matcherChain;
    }
}
