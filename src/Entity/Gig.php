<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @ORM\Entity(repositoryClass=GigRepository::class)
 * @UniqueEntity("slug")
 *
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="gig:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="gig:item"}}},
 *     order={"name"="ASC"},
 *     paginationEnabled=false
 * )
 */
class Gig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['gig:list', 'gig:item'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['gig:list', 'gig:item'])]
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['gig:list', 'gig:item'])]
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    #[Groups(['gig:list', 'gig:item'])]
    private $is_cancelled;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="gig", orphanRemoval=true)
     */
    #[Groups(['gig:list', 'gig:item'])]
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[Groups(['gig:list', 'gig:item'])]  
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="gigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIsCancelled(): ?bool
    {
        return $this->is_cancelled;
    }

    public function setIsCancelled(?bool $is_cancelled): self
    {
        $this->is_cancelled = $is_cancelled;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setGig($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getGig() === $this) {
                $comment->setGig(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string)$slugger->slug((string)$this)->lower();
        }
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
