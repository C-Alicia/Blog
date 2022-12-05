<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;




#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    /**
     * 
     *@Groups("comments:read")
     * 
     */
    
    
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]

      /* 
    *@Groups("comments:read")
  */
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    /* 
    *@Groups("comments:read")
  */
    private $autorname;

    #[ORM\Column(type: 'text', nullable: true)]
      /* 
    *@Groups("comment:read")
  */
    private $content;

    #[ORM\Column(type: 'datetime', nullable: true)]
      /* 
    *@Groups("comments:read")
  */
    private $createdAt;
 


    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAutorname(): ?string
    {
        return $this->autorname;
    }

    public function setAutorname(?string $autorname): self
    {
        $this->autorname = $autorname;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
