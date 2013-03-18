<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\Routing\Route;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * TopicRoute is the url matcher for topic path
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class TopicRoute implements UrlMatcherInterface
{
    /**
     * @var RequestContext
     */
    protected $context;
    
    /**
     * @var EntityManager
     */
    protected $em;
    
    /**
     * @var CategoryRoute
     */
    protected $cr;
    
    /**
     * Constructor.
     *
     * @param RequestContext  $context The context
     * @param EntityManager   $em      The entity manager to get repositories
     * @param CategoryRoute   $cr      The router for category
     */
    public function __construct(RequestContext $context, EntityManager $em, CategoryRoute $cr)
    {
        $this->context = $context;
        $this->em = $em;
        $this->cr = $cr;
    }
    
    /**
     * {@inheritdoc}
     */
    public function match($pathinfo) 
    {
        /** search for a topic matching the end of the pathinfo */
        $topic = $this->em->getRepository('SimpleForumBundle:Topic')->findOneBySlug(strtolower($pathinfo[0]));
        if (!$topic) {
            return false;
        }
        
        /** Reorganize pathinfo to match CategoryRouter algorithme */
        unset($pathinfo[0]);
        if (count($pathinfo) < 1) {
            return false;
        }
        $pathinfo = array_combine(range(0, count($pathinfo) - 1), $pathinfo);
        
        /** Match pathinfo with category */
        $parameters = $this->cr->match($pathinfo);
        if (!is_array($parameters)) {
            return false;
        }
        
        /** Verify if what match is the category of the topic */
        if ($topic->getCategoryId() != $parameters['entity']->getId()) {
            return false;
        }
        
        /** Set category fetched from route because parent relation are already hydrated. */
        $topic->setCategory($parameters['entity']);
        return array(
            '_controller' => 'SimpleForumBundle:Default:show',
            '_route' => 'simpleforum_dynamic_category',
            'entity' => $topic
        );
    }
    
    /**
     * {@inheritdoc}
     */
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
