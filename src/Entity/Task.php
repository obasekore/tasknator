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
 * Entity class for "Tasks" table
 */
#[Entity]
#[Table(name: "Tasks")]
class Task extends AbstractEntity
{
    #[Id]
    #[Column(name: "TaskID", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $taskId;

    #[Column(name: "UserID", type: "integer")]
    private int $userId;

    #[Column(name: "TaskerID", type: "integer", nullable: true)]
    private ?int $taskerId;

    #[Column(name: "Location", type: "text", nullable: true)]
    private ?string $location;

    #[Column(name: "StartTime", type: "datetime")]
    private DateTime $startTime;

    #[Column(name: "Status", type: "integer")]
    private int $status;

    #[Column(name: "Duration", type: "integer")]
    private int $duration;

    #[Column(name: "CreatedAt", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(name: "UpdatedAt", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    #[Column(name: "ServiceID", type: "integer", nullable: true)]
    private ?int $serviceId;

    public function __construct()
    {
        $this->status = 0;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function setTaskId(int $value): static
    {
        $this->taskId = $value;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $value): static
    {
        $this->userId = $value;
        return $this;
    }

    public function getTaskerId(): ?int
    {
        return $this->taskerId;
    }

    public function setTaskerId(?int $value): static
    {
        $this->taskerId = $value;
        return $this;
    }

    public function getLocation(): ?string
    {
        return HtmlDecode($this->location);
    }

    public function setLocation(?string $value): static
    {
        $this->location = RemoveXss($value);
        return $this;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(DateTime $value): static
    {
        $this->startTime = $value;
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

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $value): static
    {
        $this->duration = $value;
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

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function setServiceId(?int $value): static
    {
        $this->serviceId = $value;
        return $this;
    }
}
