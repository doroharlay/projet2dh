<?php

namespace Projet2\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandProduct
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet2\BackBundle\Entity\CommandProductRepository")
 */
class CommandProduct
{
    /**
    *
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Projet2\BackBundle\Entity\Command")
    */
    private $command;

    /**
    *
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="Projet2\BackBundle\Entity\Product")
    */
    private $product;

    /**
     *
     * @ORM\Column(name="productQty", type="smallint")
     */
    private $productQty;

    /**
     *
     * @ORM\Column(name="price", type="decimal")
     */
    /*private $price;*/
    
    
    
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
     * Set command
     *
     * @param array $command
     * @return CommandProduct
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return array 
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set product
     *
     * @param integer $product
     * @return CommandProduct
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return integer 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productQty
     *
     * @param integer $productQty
     * @return CommandProduct
     */
    public function setProductQty($productQty)
    {
        $this->productQty = $productQty;

        return $this;
    }

    /**
     * Get productQty
     *
     * @return integer 
     */
    public function getProductQty()
    {
        return $this->productQty;
    }
}
