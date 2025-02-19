<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, note>
     */
    #[ORM\ManyToMany(targetEntity: note::class, inversedBy: 'tags')]
    private Collection $note;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\ManyToMany(targetEntity: Note::class, mappedBy: 'tag')]
    private Collection $notes;

    public function __construct()
    {
        $this->note = new ArrayCollection();
        $this->notes = new ArrayCollection();
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

    /**
     * @return Collection<int, note>
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(note $note): static
    {
        if (!$this->note->contains($note)) {
            $this->note->add($note);
        }

        return $this;
    }

    public function removeNote(note $note): static
    {
        $this->note->removeElement($note);

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }
}
