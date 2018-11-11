<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 */
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $where_from;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $where_to;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departure;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrival;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="trip", orphanRemoval=true)
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWhereFrom(): ?string
    {
        return $this->where_from;
    }

    public function setWhereFrom(string $where_from): self
    {
        $this->where_from = $where_from;

        return $this;
    }

    public function getWhereTo(): ?string
    {
        return $this->where_to;
    }

    public function setWhereTo(string $where_to): self
    {
        $this->where_to = $where_to;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    public function setArrival(\DateTimeInterface $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setTrip($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getTrip() === $this) {
                $ticket->setTrip(null);
            }
        }

        return $this;
    }
}
