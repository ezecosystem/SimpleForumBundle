<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Jb\SimpleForumBundle\Entity\Topic;

/**
 * Load some topics for easier development using fixtures
 * 
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class LoadTopicData extends AbstractFixture implements OrderedFixtureInterface
{

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager)
  {
    $list = array(
            array(
                    'name' => 'Topic 1',
                    'content' => 'Texte du topic 1',
                    'category' => 'Science-Fiction',
            ),
            array(
                    'name' => 'Topic 2',
                    'content' => 'Texte du topic 2',
                    'category' => 'Science-Fiction',
            ),
    );

    foreach ($list as $topic) {
        $element = new Topic();
        $element->setName($topic['name']);
        $element->setContent($topic['content']);
        $element->setCategory($this->getReference('forum-'.$topic['category']));
        
        $manager->persist($element);
        $manager->flush();
        
        $this->setReference('topic-'.$topic['name'], $element);
    }
  }

  public function getOrder()
  {
    return 20;
  }
}
