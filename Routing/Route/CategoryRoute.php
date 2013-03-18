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
use Jb\SimpleForumBundle\Entity\Category;

/**
 * CategoryRoute is the url matcher for category path
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
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
        $i = 0;
        $category = $this->em->getRepository('SimpleForumBundle:Category')->findOneBySlug(strtolower($pathinfo[$i]));
        
        if (!$category) {
            return false;
        }
        
        $loopCategory = $category;
        while ($parent = $loopCategory->getParent()) {
            $i++;
            if (!isset($pathinfo[$i]) || 
                !($parent instanceof Category && $parent->getSlug() == strtolower($pathinfo[$i]))
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
