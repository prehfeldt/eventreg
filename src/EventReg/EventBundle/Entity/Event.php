<?php

namespace EventReg\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EventReg\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="EventReg\EventBundle\Entity\EventRepository")
 * @ORM\Table(name="events")
 */
class Event {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventReg\UserBundle\Entity\User")
     **/
    protected $owner;

    /**
     * @ORM\ManyToMany(targetEntity="EventReg\UserBundle\Entity\User")
     * @param ArrayCollection
     **/
    protected $attendees;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateTime;

    public function __construct() {
        $this->attendees = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    public function setDateTime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function addAttendee(User $attendee) {
        $this->attendees->add($attendee);
    }

    public function removeAttendee(User $attendee) {
        $this->attendees->removeElement($attendee);
    }

    public function getAttendees() {
        return $this->attendees;
    }
}
