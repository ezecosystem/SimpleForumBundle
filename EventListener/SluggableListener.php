<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\EventArgs;
use Jb\SimpleForumBundle\Services\Sluggable\SlugifyTools;

/**
 * Sluggify the name of category and topic on event prePersist
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class SluggableListener implements EventSubscriberInterface 
{
    /**
     * @var SlugifyTools 
     */
    private $slugifyService = null;

    /**
     * Constructor.
     * 
     * @param SlugifyTools $slugifyService the tools to slugify a string
     */
    public function __construct(SlugifyTools $slugifyService) 
    {
        $this->slugifyService = $slugifyService;
    }

    /**
     * Call on prePersist Event
     * 
     * @param EventArgs $args the arguments passed on event
     */
    public function prePersist(EventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        if ($entity instanceof \Jb\SimpleForumBundle\Entity\Category || $entity instanceof \Jb\SimpleForumBundle\Entity\Topic) {
            $entity->setSlug($this->slugifyService->slugify($entity->getName()));
        }
    }
    
    /**
     * List the events when this listener is called
     * 
     * @return array
     */
    public static function getSubscribedEvents() {
        return array(
            'prePersist'
        );
    }
}
