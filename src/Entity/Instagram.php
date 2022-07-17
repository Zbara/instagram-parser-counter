<?php

namespace App\Entity;

use App\Repository\InstagramRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InstagramRepository::class)]
class Instagram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $avatar = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: "#^https?\:\/\/(?:www\.)?instagram.com\/#",
        message: "Ссылка должна вести на Instagram."
    )]
    private ?string $login = null;

    #[ORM\Column]
    private ?int $subscriptions = null;

    #[ORM\Column]
    private ?int $subscribers = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $photos = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getSubscriptions(): ?int
    {
        return $this->subscriptions;
    }

    public function setSubscriptions(int $subscriptions): self
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }

    public function getSubscribers(): ?int
    {
        return $this->subscribers;
    }

    public function setSubscribers(int $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }
}
