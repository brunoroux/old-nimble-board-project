<?php

namespace Agile\NimbleBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agile\NimbleBoardBundle\Entity\Project
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity(repositoryClass="Agile\NimbleBoardBundle\Entity\ProjectRepository")
 */
class Project
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime $start
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime $end
     *
     * @ORM\Column(name="end", type="datetime")
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
     * @var $stories
     *
     * @ORM\OneToMany(targetEntity="Story", mappedBy="project")
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
     * Set name
     *
     * @param string $name
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * Constructor
     */
    public function __construct()
    {
        $this->stories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add stories
     *
     * @param Agile\NimbleBoardBundle\Entity\Story $stories
     * @return Project
     */
    public function addStorie(\Agile\NimbleBoardBundle\Entity\Story $stories)
    {
        $this->stories[] = $stories;
    
        return $this;
    }

    /**
     * Remove stories
     *
     * @param Agile\NimbleBoardBundle\Entity\Story $stories
     */
    public function removeStorie(\Agile\NimbleBoardBundle\Entity\Story $stories)
    {
        $this->stories->removeElement($stories);
    }

    /**
     * Get stories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStories()
    {
        return $this->stories;
    }
}