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
 * Entity class for "role" table
 */
#[Entity]
#[Table(name: "role")]
class Role extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "role_name", type: "string")]
    private string $roleName;

    #[Column(type: "integer")]
    private int $status;

    #[Column(name: "created_at", type: "datetime")]
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getRoleName(): string
    {
        return HtmlDecode($this->roleName);
    }

    public function setRoleName(string $value): static
    {
        $this->roleName = RemoveXss($value);
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
}
