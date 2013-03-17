<?php

namespace Jb\SimpleForumBundle\Routing\Route;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Jb\SimpleForumBundle\Entity\Category;

class CategoryRoute implements UrlMatcherInterface
{
    /**
     * @var RequestContext
     */
    protected $context;
    
    protected $em;
    
    /**
     * Constructor.
     *
     * @param RequestContext  $context The context
     */
    public function __construct(RequestContext $context, EntityManager $em)
    {
        $this->context = $context;
        $this->em = $em;
    }
    
    public function match($pathinfo) 
    {
        $match = true;
        
        $i = 0;
        $category = $this->em->getRepository('SimpleForumBundle:Category')->findOneBySlug($pathinfo[$i]);
        
        if (!$category) {
            return false;
        }
        
        $loopCategory = $category;
        while ($parent = $loopCategory->getParent()) {
            $i++;
            if (!isset($pathinfo[$i]) || 
                !($parent instanceof Category && $parent->getSlug() == $pathinfo[$i])
            ) {
                return false;
            }
            $loopCategory = $parent;
        }
        
        return array(
            '_controller' => 'SimpleForumBundle:Default:show',
            '_route' => 'simpleforum_dynamic_category',
            'entity' => $category
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
