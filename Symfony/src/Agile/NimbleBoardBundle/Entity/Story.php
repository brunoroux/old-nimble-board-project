<?php

namespace Agile\NimbleBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agile\NimbleBoardBundle\Entity\Story
 *
 * @ORM\Table(name="stories")
 * @ORM\Entity(repositoryClass="Agile\NimbleBoardBundle\Entity\StoryRepository")
 */
class Story
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
     * @var string $textAsA
     *
     * @ORM\Column(name="textAsA", type="string", length=255)
     */
    private $textAsA;

    /**
     * @var string $textIWant
     *
     * @ORM\Column(name="textIWant", type="string", length=255)
     */
    private $textIWant;

    /**
     * @var string $textFor
     *
     * @ORM\Column(name="textFor", type="string", length=255)
     */
    private $textFor;

    /**
     * @var string $acceptance
     *
     * @ORM\Column(name="acceptance", type="string", length=255)
     */
    private $acceptance;

    /**
     * @var integer $complexity
     *
     * @ORM\Column(name="complexity", type="integer",  nullable=true)
     */
    private $complexity;

    /**
     * @var integer $importance
     *
     * @ORM\Column(name="importance", type="integer",  nullable=true)
     */
    private $importance;

    /**
     * @var \DateTime $start
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime $end
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

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
     * @var integer $posX
     *
     * @ORM\Column(name="posX", type="integer", nullable=true)
     */
    private $posX;

    /**
     * @var integer $posY
     *
     * @ORM\Column(name="posY", type="integer", nullable=true)
     */
    private $posY;

    /**
     * @var Agile\NimbleBoardBundle\Entity\Project $project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="stories")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

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
     * Set textAsA
     *
     * @param string $textAsA
     * @return Story
     */
    public function setTextAsA($textAsA)
    {
        $this->textAsA = $textAsA;
    
        return $this;
    }

    /**
     * Get textAsA
     *
     * @return string 
     */
    public function getTextAsA()
    {
        return $this->textAsA;
    }

    /**
     * Set textIWant
     *
     * @param string $textIWant
     * @return Story
     */
    public function setTextIWant($textIWant)
    {
        $this->textIWant = $textIWant;
    
        return $this;
    }

    /**
     * Get textIWant
     *
     * @return string 
     */
    public function getTextIWant()
    {
        return $this->textIWant;
    }

    /**
     * Set textFor
     *
     * @param string $textFor
     * @return Story
     */
    public function setTextFor($textFor)
    {
        $this->textFor = $textFor;
    
        return $this;
    }

    /**
     * Get textFor
     *
     * @return string 
     */
    public function getTextFor()
    {
        return $this->textFor;
    }

    /**
     * Set acceptance
     *
     * @param string $acceptance
     * @return Story
     */
    public function setAcceptance($acceptance)
    {
        $this->acceptance = $acceptance;
    
        return $this;
    }

    /**
     * Get acceptance
     *
     * @return string 
     */
    public function getAcceptance()
    {
        return $this->acceptance;
    }

    /**
     * Set complexity
     *
     * @param integer $complexity
     * @return Story
     */
    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;
    
        return $this;
    }

    /**
     * Get complexity
     *
     * @return integer 
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * Set importance
     *
     * @param integer $importance
     * @return Story
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;
    
        return $this;
    }

    /**
     * Get importance
     *
     * @return integer 
     */
    public function getImportance()
    {
        return $this->importance;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Story
     */
    public function setStart($start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Story
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Story
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
     * @return Story
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
     * Set posX
     *
     * @param integer $posX
     * @return Story
     */
    public function setPosX($posX)
    {
        $this->posX = $posX;
    
        return $this;
    }

    /**
     * Get posX
     *
     * @return integer 
     */
    public function getPosX()
    {
        return $this->posX;
    }

    /**
     * Set posY
     *
     * @param integer $posY
     * @return Story
     */
    public function setPosY($posY)
    {
        $this->posY = $posY;
    
        return $this;
    }

    /**
     * Get posY
     *
     * @return integer 
     */
    public function getPosY()
    {
        return $this->posY;
    }

    /**
     * Set project
     *
     * @param Agile\NimbleBoardBundle\Entity\Project $project
     * @return Story
     */
    public function setProject(\Agile\NimbleBoardBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return Agile\NimbleBoardBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}