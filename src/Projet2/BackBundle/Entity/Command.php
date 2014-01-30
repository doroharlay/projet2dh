<?php

namespace Projet2\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet2\BackBundle\Entity\CommandRepository")
 */
class Command
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="totalPrice", type="decimal")
     */
    private $totalPrice;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_validate", type="boolean")
     */
    private $isValidate;
    

    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;
    
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
     * Set user
     *
     * @param integer $user
     * @return Command
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     * @return Command
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set isValidate
     *
     * @param boolean $isValidate
     * @return Command
     */
    public function setIsValidate($isValidate)
    {
        $this->isValidate = $isValidate;

        return $this;
    }

    /**
     * Get isValidate
     *
     * @return boolean 
     */
    public function getIsValidate()
    {
        return $this->isValidate;
    }
}
