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
 * Entity class for "admin" table
 */
#[Entity]
#[Table(name: "`admin`")]
class Admin extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "text")]
    private string $name;

    #[Column(type: "text")]
    private string $profile;

    #[Column(name: "role_id", type: "integer")]
    private int $roleId;

    #[Column(type: "string", unique: true)]
    private string $email;

    #[Column(type: "text")]
    private string $password;

    #[Column(name: "created_at", type: "datetime")]
    private DateTime $createdAt;

    #[Column(name: "last_login", type: "datetime")]
    private DateTime $lastLogin;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getName(): string
    {
        return HtmlDecode($this->name);
    }

    public function setName(string $value): static
    {
        $this->name = RemoveXss($value);
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

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $value): static
    {
        $this->roleId = $value;
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $value): static
    {
        $this->createdAt = $value;
        return $this;
    }

    public function getLastLogin(): DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTime $value): static
    {
        $this->lastLogin = $value;
        return $this;
    }
}
