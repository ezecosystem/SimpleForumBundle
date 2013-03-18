<?php

/*
 * This file is part of the SimpleForumBundle
 *
 * (c) Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jb\SimpleForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category entity to organize topics
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class Category implements \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var string
     */
    private $pathString;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Jb\SimpleForumBundle\Entity\Category
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $topics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Category
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set pathString
     *
     * @param string $pathString
     * @return Category
     */
    public function setPathString($pathString)
    {
        $this->pathString = $pathString;
    
        return $this;
    }

    /**
     * Get pathString
     *
     * @return string 
     */
    public function getPathString()
    {
        return $this->pathString;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Category
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add children
     *
     * @param \Jb\SimpleForumBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\Jb\SimpleForumBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Jb\SimpleForumBundle\Entity\Category $children
     */
    public function removeChildren(\Jb\SimpleForumBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Jb\SimpleForumBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\Jb\SimpleForumBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Jb\SimpleForumBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Add topics
     *
     * @param \Jb\SimpleForumBundle\Entity\Topic $topics
     * @return Category
     */
    public function addTopic(\Jb\SimpleForumBundle\Entity\Topic $topics)
    {
        $this->topics[] = $topics;
    
        return $this;
    }

    /**
     * Remove topics
     *
     * @param \Jb\SimpleForumBundle\Entity\Topic $topics
     */
    public function removeTopic(\Jb\SimpleForumBundle\Entity\Topic $topics)
    {
        $this->topics->removeElement($topics);
    }

    /**
     * Get topics
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopics()
    {
        return $this->topics;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function updateDate()
    {
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
        }
        
        $this->setUpdatedAt(new \DateTime());
    }
    
    /**
     * Return the path of the category using its parents
     * 
     * @return array
     */
    public function getPath() 
    {
        $path   = array();
        $parent = $this->getParent();
        
        if (!($parent instanceof Category)) {
            return $path;
        }
        
        $path[] = $parent;
        while ($parent = $parent->getParent()) {
            $path[] = $parent;
        }
        
        return array_reverse($path);
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return \serialize(array(
            $this->id,
            $this->name,
            $this->parentId,
            $this->pathString,
            $this->slug,
            $this->createdAt,
            $this->updatedAt,
            serialize($this->parent),
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->parentId,
            $this->pathString,
            $this->slug,
            $this->createdAt,
            $this->updatedAt,
            $parent,
        ) = \unserialize($serialized);

        $this->parent = unserialize($parent);
    }
}