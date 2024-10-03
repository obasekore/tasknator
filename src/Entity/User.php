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
 * Entity class for "Users" table
 */
#[Entity]
#[Table(name: "Users")]
class User extends AbstractEntity
{
    #[Id]
    #[Column(name: "ID", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "FirstName", type: "string")]
    private string $firstName;

    #[Column(name: "LastName", type: "string")]
    private string $lastName;

    #[Column(name: "Email", type: "string", unique: true)]
    private string $email;

    #[Column(name: "Password", type: "text")]
    private string $password;

    #[Column(name: "Token", type: "integer", nullable: true)]
    private ?int $token;

    #[Column(name: "Profile", type: "text", nullable: true)]
    private ?string $profile;

    #[Column(name: "Avatar", type: "text", nullable: true)]
    private ?string $avatar;

    #[Column(name: "CreatedAt", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(name: "UpdatedAt", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    #[Column(name: "UserLevel", type: "integer")]
    private int $userLevel;

    #[Column(name: "Status", type: "integer", nullable: true)]
    private ?int $status;

    public function __construct()
    {
        $this->userLevel = -2;
        $this->status = 1;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getFirstName(): string
    {
        return HtmlDecode($this->firstName);
    }

    public function setFirstName(string $value): static
    {
        $this->firstName = RemoveXss($value);
        return $this;
    }

    public function getLastName(): string
    {
        return HtmlDecode($this->lastName);
    }

    public function setLastName(string $value): static
    {
        $this->lastName = RemoveXss($value);
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $value): static
    {
        $this->email = $value;
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

    public function getToken(): ?int
    {
        return $this->token;
    }

    public function setToken(?int $value): static
    {
        $this->token = $value;
        return $this;
    }

    public function getProfile(): ?string
    {
        return HtmlDecode($this->profile);
    }

    public function setProfile(?string $value): static
    {
        $this->profile = RemoveXss($value);
        return $this;
    }

    public function getAvatar(): ?string
    {
        return HtmlDecode($this->avatar);
    }

    public function setAvatar(?string $value): static
    {
        $this->avatar = RemoveXss($value);
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $value): static
    {
        $this->createdAt = $value;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $value): static
    {
        $this->updatedAt = $value;
        return $this;
    }

    public function getUserLevel(): int
    {
        return $this->userLevel;
    }

    public function setUserLevel(int $value): static
    {
        $this->userLevel = $value;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $value): static
    {
        $this->status = $value;
        return $this;
    }

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('Email'),
            "userId" => $this->get('Email'),
            "parentUserId" => null,
            "userLevel" => $this->get('UserLevel') ?? AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('ID'),
        ];
    }
}
