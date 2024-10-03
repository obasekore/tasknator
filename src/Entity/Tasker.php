<?php

namespace PHPMaker2024\taskinator_project_file\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\taskinator_project_file\AbstractEntity;
use PHPMaker2024\taskinator_project_file\AdvancedSecurity;
use PHPMaker2024\taskinator_project_file\UserProfile;
use function PHPMaker2024\taskinator_project_file\Config;
use function PHPMaker2024\taskinator_project_file\EntityManager;
use function PHPMaker2024\taskinator_project_file\RemoveXss;
use function PHPMaker2024\taskinator_project_file\HtmlDecode;
use function PHPMaker2024\taskinator_project_file\EncryptPassword;

/**
 * Entity class for "tasker" table
 */
#[Entity]
#[Table(name: "tasker")]
class Tasker extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "string")]
    private string $firstname;

    #[Column(type: "string")]
    private string $lastname;

    #[Column(type: "text")]
    private string $profile;

    #[Column(type: "string", unique: true)]
    private string $email;

    #[Column(type: "text")]
    private string $password;

    #[Column(type: "integer")]
    private int $token;

    #[Column(type: "integer")]
    private int $status;

    #[Column(name: "created_at", type: "datetime")]
    private DateTime $createdAt;

    #[Column(name: "updated_at", type: "datetime")]
    private DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getFirstname(): string
    {
        return HtmlDecode($this->firstname);
    }

    public function setFirstname(string $value): static
    {
        $this->firstname = RemoveXss($value);
        return $this;
    }

    public function getLastname(): string
    {
        return HtmlDecode($this->lastname);
    }

    public function setLastname(string $value): static
    {
        $this->lastname = RemoveXss($value);
        return $this;
    }

    public function getProfile(): string
    {
        return HtmlDecode($this->profile);
    }

    public function setProfile(string $value): static
    {
        $this->profile = RemoveXss($value);
        return $this;
    }

    public function getEmail(): string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getPassword(): string
    {
        return HtmlDecode($this->password);
    }

    public function setPassword(string $value): static
    {
        $this->password = RemoveXss($value);
        return $this;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    public function setToken(int $value): static
    {
        $this->token = $value;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $value): static
    {
        $this->status = $value;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $value): static
    {
        $this->createdAt = $value;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $value): static
    {
        $this->updatedAt = $value;
        return $this;
    }
}
