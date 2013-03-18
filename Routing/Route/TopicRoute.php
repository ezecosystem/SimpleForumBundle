<?php

namespace Jb\SimpleForumBundle\Routing\Route;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Jb\SimpleForumBundle\Entity\Category;
use Jb\SimpleForumBundle\Entity\Topic;

class TopicRoute implements UrlMatcherInterface
{
    /**
     * @var RequestContext
     */
    protected $context;
    
    protected $em;
    
    protected $cr;
    
    /**
     * Constructor.
     *
     * @param RequestContext  $context The context
     */
    public function __construct(RequestContext $context, EntityManager $em, CategoryRoute $cr)
    {
        $this->context = $context;
        $this->em = $em;
        $this->cr = $cr;
    }
    
    public function match($pathinfo) 
    {
        $topic = $this->em->getRepository('SimpleForumBundle:Topic')->findOneBySlug($pathinfo[0]);
        if (!$topic) {
            return false;
        }
        
        unset($pathinfo[0]);
        if (count($pathinfo) < 1) {
            return false;
        }
        $pathinfo = array_combine(range(0, count($pathinfo) - 1), $pathinfo);
        
        $parameters = $this->cr->match($pathinfo);
        if (!is_array($parameters)) {
            return false;
        }
        
        if ($topic->getCategoryId() != $parameters['entity']->getId()) {
            return false;
        }
        
        // Set category fetched from route because parent relation are already hydrated.
        $topic->setCategory($parameters['entity']);
        return array(
            '_controller' => 'SimpleForumBundle:Default:show',
            '_route' => 'simpleforum_dynamic_category',
            'entity' => $topic
        );
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
