<?php

namespace Agile\NimbleBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agile\NimbleBoardBundle\Entity\Sprint
 *
 * @ORM\Table(name="sprints")
 * @ORM\Entity(repositoryClass="Agile\NimbleBoardBundle\Entity\SprintRepository")
 */
class Sprint
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $number
     *
     * @Assert\NotBlank(message="sprint.number.not_blank")
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var integer $week
     *
     * @Assert\NotBlank(message="sprint.week.not_blank")
     * @Assert\Min(limit=1, message="sprint.week.valueRange")
     * @Assert\Max(limit=52, message="sprint.week.valueRange")
     * @ORM\Column(name="week", type="integer")
     */
    private $week;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $changed
     *
     * @ORM\Column(name="changed", type="datetime")
     */
    private $changed;

    /**
     * @var \Agile\NimbleBoardBundle\Entity\Project $project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="sprints")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @var $stories
     *
     * @ORM\OneToMany(targetEntity="Story", mappedBy="sprint")
     */
    private $stories;

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
     * Set number
     *
     * @param integer $number
     * @return Sprint
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set week
     *
     * @param integer $week
     * @return Sprint
     */
    public function setWeek($week)
    {
        $this->week = $week;
    
        return $this;
    }

    /**
     * Get week
     *
     * @return integer 
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Sprint
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     * @return Sprint
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;
    
        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime 
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set project
     *
     * @param \Agile\NimbleBoardBundle\Entity\Project $project
     * @return Sprint
     */
    public function setProject(\Agile\NimbleBoardBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \Agile\NimbleBoardBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add stories
     *
     * @param \Agile\NimbleBoardBundle\Entity\Story $stories
     * @return Sprint
     */
    public function addStorie(\Agile\NimbleBoardBundle\Entity\Story $stories)
    {
        $this->stories[] = $stories;
    
        return $this;
    }

    /**
     * Remove stories
     *
     * @param \Agile\NimbleBoardBundle\Entity\Story $stories
     */
    public function removeStorie(\Agile\NimbleBoardBundle\Entity\Story $stories)
    {
        $this->stories->removeElement($stories);
    }

    /**
     * Get stories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStories()
    {
        return $this->stories;
    }
}