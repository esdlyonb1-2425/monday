<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read-truc'])]

    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read-truc'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Truc>
     */
    #[ORM\OneToMany(targetEntity: Truc::class, mappedBy: 'category')]
    private Collection $trucs;

    public function __construct()
    {
        $this->trucs = new ArrayCollection();
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
     * @return Collection<int, Truc>
     */
    public function getTrucs(): Collection
    {
        return $this->trucs;
    }

    public function addTruc(Truc $truc): static
    {
        if (!$this->trucs->contains($truc)) {
            $this->trucs->add($truc);
            $truc->setCategory($this);
        }

        return $this;
    }

    public function removeTruc(Truc $truc): static
    {
        if ($this->trucs->removeElement($truc)) {
            // set the owning side to null (unless already changed)
            if ($truc->getCategory() === $this) {
                $truc->setCategory(null);
            }
        }

        return $this;
    }


}
