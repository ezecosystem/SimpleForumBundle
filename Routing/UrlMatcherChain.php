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

use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

/**
 * UrlMatcherChain is the service which get all router service tagged simpleforum.urlmatcher
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class UrlMatcherChain 
{
    /**
     * @var array
     */
    private $matchers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matchers = array();
    }

    /**
     * Add an url matcher service to the chain
     * 
     * @param UrlMatcherInterface $matcher an url matcher
     */
    public function addMatcher(UrlMatcherInterface $matcher )
    {
        $this->matchers[] = $matcher;
    }
    
    /**
     * Get all matchers
     * 
     * @return array
     */
    public function getMatchers() 
    {
        return $this->matchers;
    }
}
