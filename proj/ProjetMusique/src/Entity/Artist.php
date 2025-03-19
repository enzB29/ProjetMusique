<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['artist:read', 'event:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artist:read', 'event:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['artist:read'])]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(['artist:read'])]
    private ?string $image = null;

    private ?File $imageFile = null;

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

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function uploadImage(): void
    {
        // Check if an image file was uploaded
        if ($this->imageFile) {
            // Generate a unique filename for the image (avoid collisions)
            $filename = uniqid() . '.' . $this->imageFile->guessExtension();

            // Define the directory where the image should be stored
            $targetDirectory = 'public/uploads/artists';

            // Move the file to the target directory
            $this->imageFile->move(
                $targetDirectory,
                $filename
            );

            // Save the filename (not the whole file) in the database
            $this->image = $filename;

            // Reset the imageFile property after it has been moved
            $this->imageFile = null;
        }
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
