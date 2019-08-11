<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Magics
 *
 * @ORM\Table(name="magics")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\MagicsRepository")
 */
class Magics
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
     * @ORM\Column(name="img", type="string", length=255, unique=true)
     */
    private $img;

    /**
     * @var int
     *
     * @ORM\Column(name="dmg", type="integer")
     */
    private $dmg;

    /**
     * @var int
     *
     * @ORM\Column(name="percentChance", type="integer")
     */
    private $percentChance;

    /**
     * @var int
     *
     * @ORM\Column(name="armor", type="integer")
     */
    private $armor;

    /**
     * @var int
     *
     * @ORM\Column(name="dodge", type="integer")
     */
    private $dodge;

    /**
     * @var int
     *
     * @ORM\Column(name="heal", type="integer")
     */
    private $heal;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="critical", type="integer")
     */
    private $critical;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SoftUniBlogBundle\Entity\Hero", mappedBy="magic", cascade={"remove"})
     */
    private $heroes;


    public function __construct($img, $dmg, $percentChance, $armor, $dodge, $heal, $name, $description, $type, $critical)
    {
        $this->heroes = new ArrayCollection();
        $this->img = $img;
        $this->dmg = $dmg;
        $this->percentChance = $percentChance;
        $this->armor = $armor;
        $this->dodge = $dodge;
        $this->heal = $heal;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->critical = $critical;
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
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Magics
     */
    public function setType(int $type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * Set img
     *
     * @param string $img
     *
     * @return Magics
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Magics
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

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

    /**
     * Set dmg
     *
     * @param integer $dmg
     *
     * @return Magics
     */
    public function setDmg($dmg)
    {
        $this->dmg = $dmg;

        return $this;
    }

    /**
     * Get dmg
     *
     * @return int
     */
    public function getDmg()
    {
        return $this->dmg;
    }

    /**
     * Set cooldown
     *
     * @param integer $percentChance
     *
     * @return Magics
     */
    public function setPercentChance($percentChance)
    {
        $this->percentChance = $percentChance;

        return $this;
    }

    /**
     * Get percentChance
     *
     * @return int
     */
    public function getPercentChance()
    {
        return $this->percentChance;
    }

    /**
     * Set armor
     *
     * @param integer $armor
     *
     * @return Magics
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * Get armor
     *
     * @return int
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * Set dodge
     *
     * @param integer $dodge
     *
     * @return Magics
     */
    public function setDodge($dodge)
    {
        $this->dodge = $dodge;

        return $this;
    }

    /**
     * Get dodge
     *
     * @return int
     */
    public function getDodge()
    {
        return $this->dodge;
    }

    /**
     * Set heal
     *
     * @param integer $heal
     *
     * @return Magics
     */
    public function setHeal($heal)
    {
        $this->heal = $heal;

        return $this;
    }

    /**
     * Get heal
     *
     * @return int
     */
    public function getHeal()
    {
        return $this->heal;
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Magics
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
     * Set critical
     *
     * @param integer $critical
     *
     * @return Magics
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;

        return $this;
    }

    /**
     * Get critical
     *
     * @return int
     */
    public function getCritical()
    {
        return $this->critical;
    }
}

