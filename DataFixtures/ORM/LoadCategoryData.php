<?php

namespace Jb\SimpleForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Jb\SimpleForumBundle\Entity\ForumCategory;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager)
  {
    $list = array(
            array(
                    'name' => 'Forum',
            ),
            array(
                    'name' => 'Film',
                    'parent' => 'Forum',
            ),
            array(
                    'name' => 'Science-Fiction',
                    'parent' => 'Film',
            ),
            array(
                    'name' => 'Science-Fiction',
                    'parent' => 'Film',
            ),
            array(
                    'name' => 'Series',
                    'parent' => 'Forum',
            ),
            array(
                    'name' => 'Science-Fiction',
                    'parent' => 'Series',
            ),
    );

    foreach ($list as $forum) {
        $element = new ForumCategory();
        $element->setName($forum['name']);
        
        if (isset($forum['parent'])) 
        {
            $element->setParent($this->getReference('forum-'.$forum['parent']));
            $pathString = $this->getReference('forum-'.$forum['parent'])->getPathString();
            if (is_null($pathString)) {
                $pathString = '/'.$this->getReference('forum-'.$forum['parent'])->getId().'/';
            } else {
                $pathString .= $this->getReference('forum-'.$forum['parent'])->getId().'/';
            }
            $element->setPathString($pathString);
        }
        $manager->persist($element);
        $manager->flush();
        
        $this->setReference('forum-'.$forum['name'], $element);
    }
  }

  public function getOrder()
  {
    return 1;
  }
}
