<?php

namespace App\Entity;

use App\Repository\LangageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangageRepository::class)]
class Langage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $display_name = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $technical_name = null;

    /**
     * @var Collection<int, note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'langage')]
    private Collection $note;

    public function __construct()
    {
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function setDisplayName(string $display_name): static
    {
        $this->display_name = $display_name;

        return $this;
    }

    public function getTechnicalName(): ?string
    {
        return $this->technical_name;
    }

    public function setTechnicalName(string $technical_name): static
    {
        $this->technical_name = $technical_name;

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
            $note->setLangage($this);
        }

        return $this;
    }

    public function removeNote(note $note): static
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getLangage() === $this) {
                $note->setLangage(null);
            }
        }

        return $this;
    }
}
