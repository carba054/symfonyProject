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
     * @ORM\Column(name="cooldown", type="integer")
     */
    private $cooldown;

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
     * @var int
     *
     * @ORM\Column(name="disarm", type="integer")
     */
    private $disarm;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="silence", type="integer")
     */
    private $silence;

    /**
     * @var int
     *
     * @ORM\Column(name="critical", type="integer")
     */
    private $critical;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SoftUniBlogBundle\Entity\Hero", mappedBy="magic")
     */
    private $heroes;

    private function __construct()
    {
        $this->heroes = new ArrayCollection();
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
     * @param integer $cooldown
     *
     * @return Magics
     */
    public function setCooldown($cooldown)
    {
        $this->cooldown = $cooldown;

        return $this;
    }

    /**
     * Get cooldown
     *
     * @return int
     */
    public function getCooldown()
    {
        return $this->cooldown;
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
     * Set disarm
     *
     * @param integer $disarm
     *
     * @return Magics
     */
    public function setDisarm($disarm)
    {
        $this->disarm = $disarm;

        return $this;
    }

    /**
     * Get disarm
     *
     * @return int
     */
    public function getDisarm()
    {
        return $this->disarm;
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
     * Set silence
     *
     * @param integer $silence
     *
     * @return Magics
     */
    public function setSilence($silence)
    {
        $this->silence = $silence;

        return $this;
    }

    /**
     * Get silence
     *
     * @return int
     */
    public function getSilence()
    {
        return $this->silence;
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

