<?php

namespace App\Entity;

use App\Entity\Author;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: "App\Repository\PostRepository")]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'post:read']
        ),
        new Get(
            normalizationContext: ['groups' => 'post:read']
        )
    ]
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "integer")]
    #[Groups(["post:read"])]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(["post:read"])]
    private $title;

    #[ORM\Column(type: "text")]
    #[Groups(["post:read"])]
    private $body;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Author")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["post:read"])]
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;
        return $this;
    }
}
