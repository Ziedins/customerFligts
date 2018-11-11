<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Passanger", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $passanger;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassanger(): ?Passanger
    {
        return $this->passanger;
    }

    public function setPassanger(?Passanger $passanger): self
    {
        $this->passanger = $passanger;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }
}
