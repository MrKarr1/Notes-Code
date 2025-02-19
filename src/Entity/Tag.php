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
    private Collection $note_tag;

    #[ORM\ManyToOne(inversedBy: 'tag')]
    private ?Langage $langage = null;

    public function __construct()
    {
        $this->note_tag = new ArrayCollection();
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
    public function getNoteTag(): Collection
    {
        return $this->note_tag;
    }

    public function addNoteTag(note $noteTag): static
    {
        if (!$this->note_tag->contains($noteTag)) {
            $this->note_tag->add($noteTag);
        }

        return $this;
    }

    public function removeNoteTag(note $noteTag): static
    {
        $this->note_tag->removeElement($noteTag);

        return $this;
    }

    public function getLangage(): ?Langage
    {
        return $this->langage;
    }

    public function setLangage(?Langage $langage): static
    {
        $this->langage = $langage;

        return $this;
    }
}
