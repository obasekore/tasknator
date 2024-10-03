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
 * Entity class for "Services" table
 */
#[Entity]
#[Table(name: "Services")]
class Service extends AbstractEntity
{
    #[Id]
    #[Column(name: "ServiceID", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $serviceId;

    #[Column(name: "ServiceName", type: "string")]
    private string $serviceName;

    #[Column(name: "ParentService", type: "integer")]
    private int $parentService;

    #[Column(name: "Status", type: "integer")]
    private int $status;

    #[Column(name: "Options", type: "json")]
    private mixed $options;

    #[Column(name: "CreatedAt", type: "datetime")]
    private DateTime $createdAt;

    #[Column(name: "UpdatedAt", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    public function __construct()
    {
        $this->parentService = 0;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $value): static
    {
        $this->serviceId = $value;
        return $this;
    }

    public function getServiceName(): string
    {
        return HtmlDecode($this->serviceName);
    }

    public function setServiceName(string $value): static
    {
        $this->serviceName = RemoveXss($value);
        return $this;
    }

    public function getParentService(): int
    {
        return $this->parentService;
    }

    public function setParentService(int $value): static
    {
        $this->parentService = $value;
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

    public function getOptions(): mixed
    {
        return HtmlDecode($this->options);
    }

    public function setOptions(mixed $value): static
    {
        $this->options = RemoveXss($value);
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

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $value): static
    {
        $this->updatedAt = $value;
        return $this;
    }
}
