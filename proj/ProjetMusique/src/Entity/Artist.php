<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'artist', orphanRemoval: true)]
    private Collection $eventList;

    public function __construct()
    {
        $this->eventList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEventList(): Collection
    {
        return $this->eventList;
    }

    public function addEventList(Event $eventList): static
    {
        if (!$this->eventList->contains($eventList)) {
            $this->eventList->add($eventList);
            $eventList->setArtist($this);
        }

        return $this;
    }

    public function removeEventList(Event $eventList): static
    {
        if ($this->eventList->removeElement($eventList)) {
            // set the owning side to null (unless already changed)
            if ($eventList->getArtist() === $this) {
                $eventList->setArtist(null);
            }
        }

        return $this;
    }
}
