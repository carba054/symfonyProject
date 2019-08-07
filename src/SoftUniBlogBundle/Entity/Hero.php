<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hero
 *
 * @ORM\Table(name="heroes")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\HeroRepository")
 */
class Hero
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxHealth", type="integer")
     */
    private $maxHealth;
    /**
     * @var integer
     * @ORM\Column(name="currentHealth", type="integer")
     */
    private $currentHealth;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="strength", type="integer")
     */
    private $strength;

    /**
     * @var integer
     *
     * @ORM\Column(name="agility", type="integer")
     */
    private $agility;

    /**
     * @var integer
     *
     * @ORM\Column(name="intelligence", type="integer")
     */
    private $intelligence;

    /**
     * @var integer
     *
     * @ORM\Column(name="luck", type="integer")
     */
    private $luck;

    /**
     *
     * @var Types
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\Types", inversedBy="heroes")
     * @ORM\JoinColumn(name="typeId", referencedColumnName="id")
     *
     */
    private $typeId;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="SoftUniBlogBundle\Entity\Magics")
     * @ORM\JoinTable(name="heroes_magics",
     *     joinColumns={@ORM\JoinColumn(name="hero_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="magic_id", referencedColumnName="id")})
     *
     */
    private $magics;


    /**
     * @var integer
     *
     * @ORM\Column(name="dmg", type="integer")
     */
    private $dmg;

    /**
     * @var double
     *
     * @ORM\Column(name="armor", type="decimal")
     */
    private $armor;

    /**
     * @var integer
     *
     * @ORM\Column(name="weapon", type="integer")
     */
    private $weapon;

    /**
     * @var integer
     *
     * @ORM\Column(name="shield", type="integer")
     */
    private $shield;

    /**
     * @var integer
     *
     * @ORM\Column(name="money", type="integer")
     */
    private $money;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;


    /**
     * @var User
     * @ORM\OneToOne(targetEntity="SoftUniBlogBundle\Entity\User", inversedBy="hero")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="id")
     */

    private $ownerId;

    /**
     * @var integer
     * @ORM\Column(name="viewCount", type="integer")
     *
     */
    private $viewCount;


    /**
     * @var integer
     * @ORM\Column(name="wins", type="integer")
     */
    private $wins;
    /**
     * @var integer
     * @ORM\Column(name="losses", type="integer")
     */
    private $losses;
    /**
     * @var integer
     * @ORM\Column(name="draws", type="integer")
     */
    private $draws;

    /**
     * @var integer;
     * @ORM\Column(name="experience", type="integer")
     */
    private $experience;

    /**
     * @var double
     * @ORM\Column(name="miss", type="decimal")
     */
    private $miss;

    /**
     * @var double
     * @ORM\Column(name="disarm", type="decimal")
     */
    private $disarm;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SoftUniBlogBundle\Entity\Reports", mappedBy="attackerId");
     */
    private $reportsAttack;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SoftUniBlogBundle\Entity\Reports", mappedBy="defenderId");
     */
    private $reportsDefend;


    public function __construct()
    {
        $this->dateAdded = new \DateTime('now');
        $this->magics = new ArrayCollection();
        $this->reportsAttack = new ArrayCollection();
        $this->reportsDefend = new ArrayCollection();
        $this->level = 1;
        $this->setStrength(20);
        $this->setAgility(20);
        $this->setIntelligence(20);
        $this->setLuck(20);



        $this->weapon = 0;
        $this->shield = 0;
        $this->setCurrentHealth(100);
        $this->setMoney(500);
        $this->wins = 0;
        $this->losses = 0;
        $this->draws = 0;
        $this->experience = 100;



    }

    /**
     * @return array (Reports|string)[]
     */
    public function getReportsAttack()
    {
        $stringReport = [];
        /**
         * @var Reports $report
         */


        foreach ($this->reportsAttack as $report) {
            $stringReport[] = $report->getId();
        }


        return $stringReport;
    }

    /**
     * @param Reports $reportsAttack
     */
    public function setReportsAttack(Reports $reportsAttack)
    {
        $this->reportsAttack[] = $reportsAttack;
    }

    /**
     * @return array (Reports|string)[]
     */
    public function getReportsDefend()
    {
        $stringReport = [];
        /**
         * @var Reports $report
         */
        foreach ($this->reportsDefend as $report) {
            $stringReport[] = $report->getId();
        }

        return $stringReport;

    }

    /**
     * @param Reports $reportsDefend
     */
    public function setReportsDefend(Reports $reportsDefend)
    {
        $this->reportsDefend[] = $reportsDefend;
    }



    /**
     * @return double
     */
    public function getMiss()
    {
        return $this->miss;
    }

    /**
     * @return Hero
     */
    public function setMiss($miss)
    {
        $this->miss = $miss;
        return $this;
    }

    /**
     * @return double
     */
    public function getDisarm()
    {
        return $this->disarm;
    }

    /**
     * @return Hero
     */
    public function setDisarm($disarm)
    {
        $this->disarm = $disarm;
        return $this;
    }


    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     * @return Hero
     */
    public function setExperience(int $experience)
    {
        $this->experience = $experience;
        return $this;
    }


    /**
     * @return int
     */
    public function getCurrentHealth(): int
    {
        return $this->currentHealth;
    }

    /**
     * @param int $currentHealth
     * @return Hero
     */
    public function setCurrentHealth(int $currentHealth)
    {
        $this->currentHealth = $currentHealth;
        return $this;
    }



    /**
     * @return array (Magics|string)[]
     */
    public function getMagics()
    {
        $stringMagics = [];
        /**
         * @var Magics $magic
         */
        foreach ($this->magics as $magic) {
            $stringMagics[] = $magic->getId();
        }

        return $stringMagics;

    }

    /**
     * @return Hero
     */
    public function setMagics($magics)
    {
        $this->magics[] = $magics;
        return $this;
    }


    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     */
    public function setViewCount(int $viewCount)
    {
        $this->viewCount = $viewCount;
    }




    /**
     * @return User
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param User $owner
     * @return Hero
     */
    public function setOwnerId(User $owner)
    {

        $this->ownerId = $owner;

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
     * Set title
     *
     * @param string $name
     *
     * @return Hero
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
     * Set maxHealth
     *
     * @param integer $maxHealth
     *
     * @return Hero
     */
    public function setMaxHealth($maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Hero
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Hero
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     * @return Hero
     */
    public function setStrength(int $strength)
    {
        $health = $strength*5;
        $this->setMaxHealth($health);
        $dmg= intval($strength*0.4);


        if ($this->getTypeId() == null){
            $this->setDmg($dmg);
        }else{
            $type = $this->getTypeId();

            if ($type->getId() == 1){

                $this->setDmg($dmg);
            }

        }



        $this->strength = $strength;


        return $this;
    }

    /**
     * @return int
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * @param int $agility
     * @return Hero
     */
    public function setAgility(int $agility)
    {
        $miss = $agility*0.1;
        $this->setMiss($miss);
        $dmg= intval($agility*0.4);
        if ($this->getTypeId() == null){
            $this->setDmg($dmg);
        }else{
            $type = $this->getTypeId();

            if ($type->getId() == 2){


                $this->setDmg($dmg);
            }
        }

        $this->agility = $agility;
        return $this;
    }

    /**
     * @return int
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @param int $intelligence
     * @return Hero
     */
    public function setIntelligence(int $intelligence)
    {
        $armor = $intelligence*0.5;
        $this->setArmor($armor);
        $dmg= intval($intelligence*0.4);
        if ($this->getTypeId() == null){
            $this->setDmg($dmg);
        }else{
            $type = $this->getTypeId();

            if ($type->getId() == 3){


                $this->setDmg($dmg);
            }
        }

        $this->intelligence = $intelligence;
        return $this;
    }

    /**
     * @return int
     */
    public function getLuck()
    {
        return $this->luck;
    }

    /**
     * @param int $luck
     * @return Hero
     */
    public function setLuck(int $luck)
    {
        $disarm = $luck*0.25;
        $this->setDisarm($disarm);

        $this->luck = $luck;
        return $this;
    }

    /**
     * @return Types
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param Types $typeId
     * @return Hero|integer
     */
    public function setTypeId(Types $typeId =null)
    {
        $this->typeId = $typeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getDmg()
    {
        return $this->dmg;
    }

    /**
     * @param int $dmg
     * @return Hero
     */
    public function setDmg(int $dmg)
    {
        $this->dmg = $dmg;
        return $this;
    }

    /**
     * @return double
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * @return Hero
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * @param int $weapon
     * @return Hero
     */
    public function setWeapon(int $weapon)
    {
        $this->weapon = $weapon;
        return $this;
    }

    /**
     * @return int
     */
    public function getShield()
    {
        return $this->shield;
    }

    /**
     * @param int $shield
     * @return Hero
     */
    public function setShield(int $shield)
    {
        $this->shield = $shield;
        return $this;
    }

    /**
     * @return int
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param int $money
     * @return Hero
     */
    public function setMoney(int $money)
    {
        $this->money = $money;
        return $this;
    }

    /**
     * @return int
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * @param int $wins
     * @return Hero
     */
    public function setWins(int $wins)
    {
        $this->wins = $wins;
        return $this;
    }

    /**
     * @return int
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * @param int $losses
     * @return Hero
     */
    public function setLosses(int $losses)
    {
        $this->losses = $losses;
        return $this;
    }

    /**
     * @return int
     */
    public function getDraws()
    {
        return $this->draws;
    }

    /**
     * @param int $draws
     * @return Hero
     */
    public function setDraws(int $draws)
    {
        $this->draws = $draws;
        return $this;
    }



}

