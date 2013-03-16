<?php

namespace Jb\SimpleForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumCategory
 */
class ForumCategory
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
     * @var \Jb\SimpleForumBundle\Entity\ForumCategory
     */
    private $parent;

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
     * @return ForumCategory
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
     * @return ForumCategory
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
     * @return ForumCategory
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
     * @return ForumCategory
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ForumCategory
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
     * @return ForumCategory
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
     * @param \Jb\SimpleForumBundle\Entity\ForumCategory $children
     * @return ForumCategory
     */
    public function addChildren(\Jb\SimpleForumBundle\Entity\ForumCategory $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Jb\SimpleForumBundle\Entity\ForumCategory $children
     */
    public function removeChildren(\Jb\SimpleForumBundle\Entity\ForumCategory $children)
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
     * @param \Jb\SimpleForumBundle\Entity\ForumCategory $parent
     * @return ForumCategory
     */
    public function setParent(\Jb\SimpleForumBundle\Entity\ForumCategory $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Jb\SimpleForumBundle\Entity\ForumCategory 
     */
    public function getParent()
    {
        return $this->parent;
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
}
