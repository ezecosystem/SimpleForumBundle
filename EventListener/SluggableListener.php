<?php

namespace Jb\SimpleForumBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\EventArgs;
use Jb\SimpleForumBundle\Services\Sluggable\SlugifyTools;

class SluggableListener implements EventSubscriberInterface 
{
    private $slugifyService = null;

    public function __construct(SlugifyTools $slugifyService) 
    {
        $this->slugifyService = $slugifyService;
    }

    public function prePersist(EventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        if ($entity instanceof \Jb\SimpleForumBundle\Entity\Category || $entity instanceof \Jb\SimpleForumBundle\Entity\Topic) {
            $entity->setSlug($this->slugifyService->slugify($entity->getName()));
        }
    }
    
    public static function getSubscribedEvents() {
        return array(
            'prePersist'
        );
    }
}

?>
