<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $emailRecipient;

    #[ORM\Column(type: 'string', length: 255)]
    private $sujet;

    #[ORM\Column(type: 'text')]
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailRecipient(): ?string
    {
        return $this->emailRecipient;
    }

    public function setEmailRecipient(string $emailRecipient): self
    {
        $this->emailRecipient = $emailRecipient;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
