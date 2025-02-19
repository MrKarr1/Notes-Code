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

    #[ORM\Column(length: 50)]
    private ?string $technical_name = null;

    /**
     * @var Collection<int, tag>
     */
    #[ORM\OneToMany(targetEntity: tag::class, mappedBy: 'langage')]
    private Collection $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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
     * @return Collection<int, tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(tag $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
            $tag->setLangage($this);
        }

        return $this;
    }

    public function removeTag(tag $tag): static
    {
        if ($this->tag->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getLangage() === $this) {
                $tag->setLangage(null);
            }
        }

        return $this;
    }
}
