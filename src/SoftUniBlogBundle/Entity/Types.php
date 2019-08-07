<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Types
 *
 * @ORM\Table(name="types")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\TypesRepository")
 */
class Types
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, unique=true)
     */
    private $img;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SoftUniBlogBundle\Entity\Hero", mappedBy="typeId")
     */
    private $heroes;

    public function __construct()
    {
        $this->heroes = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getHeroes()
    {
        return $this->heroes;
    }

    /**
     * @param ArrayCollection $heroes
     * @return Types
     */
    public function setHeroes(Hero $heroes)
    {
        $this->heroes[] = $heroes;
        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Types
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
     * Set img
     *
     * @param string $img
     *
     * @return Types
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }
}

