<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * reports
 *
 * @ORM\Table(name="reports")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\ReportRepository")
 */
class Reports
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
     * @ORM\Column(name="round1", type="string", length=255, nullable=true)
     */
    private $round1;

    /**
     *@var Hero
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\Hero", inversedBy="reportsAttack", cascade={"persist"});
     * @ORM\JoinColumn(name="attackerId", referencedColumnName="id", onDelete="CASCADE")
     */
    private $attackerId;

    /**
     *@var Hero
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\Hero", inversedBy="reportsDefend", cascade={"persist"});
     * @ORM\JoinColumn(name="defenderId", referencedColumnName="id", onDelete="CASCADE")
     */
    private $defenderId;

    /**
     * @var string
     * @ORM\Column(name="round2", type="string", length=255, nullable=true)
     */
    private $round2;

    /**
     * @var string
     * @ORM\Column(name="round3", type="string", length=255, nullable=true)
     */
    private $round3;
    /**
     * @var string
     * @ORM\Column(name="round4", type="string", length=255, nullable=true)
     */
    private $round4;
    /**
     * @var string
     * @ORM\Column(name="round5", type="string", length=255, nullable=true)
     */
    private $round5;
    /**
     * @var string
     * @ORM\Column(name="round6", type="string", length=255, nullable=true)
     */
    private $round6;
    /**
     * @var string
     * @ORM\Column(name="round7", type="string", length=255, nullable=true)
     */
    private $round7;
    /**
     * @ORM\Column(name="winner", type="integer", nullable=true)
     *
     */
    private $winner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


        public function __construct(array $reports)
        {
            $this->date = new \DateTime('now');
            foreach ($reports as $key=>$report) {
                $this->$key = $report;
            }

        }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Reports
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }


    /**
     * @return integer
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @return Reports
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
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
     * Get result
     *
     * @return string
     */
    public function getRound1()
    {
        return $this->round1;
    }

    /**
     * Set result
     *
     * @param string $round1
     *
     * @return reports
     */
    public function setRound1($round1)
    {
        $this->round1 = $round1;

        return $this;
    }


    /**
     * @return string
     */
    public function getRound2()
    {
        return $this->round2;
    }

    /**
     * @param string $round2
     * @return Reports
     */
    public function setRound2(string $round2)
    {
        $this->round2 = $round2;
        return $this;
    }

    /**
     * @return string
     */
    public function getRound3()
    {
        return $this->round3;
    }

    /**
     * @param string $round3
     * @return Reports
     */
    public function setRound3(string $round3)
    {
        $this->round3 = $round3;
        return $this;
    }

    /**
     * @return string
     */
    public function getRound4()
    {
        return $this->round4;
    }

    /**
     * @param string $round4
     * @return Reports
     */
    public function setRound4(string $round4)
    {
        $this->round4 = $round4;
        return $this;
    }

    /**
     * @return string
     */
    public function getRound5()
    {
        return $this->round5;
    }

    /**
     * @param string $round5
     * @return Reports
     */
    public function setRound5(string $round5)
    {
        $this->round5 = $round5;
        return $this;
    }

    /**
     * @return string
     */
    public function getRound6()
    {
        return $this->round6;
    }

    /**
     * @param string $round6
     * @return Reports
     */
    public function setRound6(string $round6)
    {
        $this->round6 = $round6;
        return $this;
    }

    /**
     * @return string
     */
    public function getRound7()
    {
        return $this->round7;
    }

    /**
     * @param string $round7
     * @return Reports
     */
    public function setRound7(string $round7)
    {
        $this->round7 = $round7;
        return $this;
    }


    /**
     * Set attackerId
     *
     * @param Hero $attackerId
     *
     * @return reports
     */
    public function setAttackerId(Hero $attackerId)
    {
        $this->attackerId = $attackerId;

        return $this;
    }

    /**
     * Get attackerId
     *
     * @return Hero
     */
    public function getAttackerId()
    {
        return $this->attackerId;
    }

    /**
     * Set defenderId
     *
     * @param Hero $defenderId
     *
     * @return reports
     */
    public function setDefenderId(Hero $defenderId)
    {
        $this->defenderId = $defenderId;

        return $this;
    }

    /**
     * Get defenderId
     *
     * @return Hero
     */
    public function getDefenderId()
    {
        return $this->defenderId;
    }
}

