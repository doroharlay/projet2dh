<?php

namespace Projet2\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet2\BackBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(name="name", type="string", length=50, unique=TRUE)
     */
    private $name;
    
    /**
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\Column(name="image", type="string", length=100)
     */
    private $image;

    /**
     *
     * @ORM\Column(name="expirationDate", type="date")
     */
    private $expirationDate;

    /**
     *
     * @ORM\Column(name="creationDate", type="date")
     */
    private $creationDate;

    /**
     *
     * @ORM\Column(name="is_available", type="boolean")
     */
    private $isAvailable;

    /**
     *
     * @ORM\Column(name="stockQty", type="integer")
     */
    private $stockQty;

    /* relations avec autres entités****************************/
    
    /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     **/
    private $type;
       
     /**
      * 
     *@ORM\ManyToMany(targetEntity="Projet2\BackBundle\Entity\Category", cascade={"persist"})
      * 
     **/
    
    private $categories;
    
    
    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
     /**
     * Add categories
     *
     * @param \Projet2\BackBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategory(\Projet2\BackBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Projet2\BackBundle\Entity\Category $categories
     */
    public function removeCategory(\Projet2\BackBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
  
    
    
    /*  Autres Getters et Setters */
    
    
       
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    public function setStockQty($stockQty)
    {
        $this->stockQty = $stockQty;

        return $this;
    }

    public function getStockQty()
    {
        return $this->stockQty;
    }


    /**
     * Set type
     *
     * @param \Projet2\BackBundle\Entity\Type $type
     * @return Product
     */
    public function setType(\Projet2\BackBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Projet2\BackBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

}
