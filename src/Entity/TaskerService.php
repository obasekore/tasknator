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
 * Entity class for "TaskerService" table
 */
#[Entity]
#[Table(name: "TaskerService")]
class TaskerService extends AbstractEntity
{
    #[Id]
    #[Column(name: "TaskerServiceID", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $taskerServiceId;

    #[Column(name: "UserID", type: "integer")]
    private int $userId;

    #[Column(name: "ServiceID", type: "integer")]
    private int $serviceId;

    #[Column(name: "AverageRating", type: "integer", nullable: true)]
    private ?int $averageRating;

    #[Column(name: "ReviewCount", type: "integer", nullable: true)]
    private ?int $reviewCount;

    #[Column(name: "Status", type: "integer", nullable: true)]
    private ?int $status;

    #[Column(name: "CreatedAt", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(name: "UpdatedAt", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    public function __construct()
    {
        $this->averageRating = 0;
        $this->reviewCount = 0;
        $this->status = 1;
    }

    public function getTaskerServiceId(): int
    {
        return $this->taskerServiceId;
    }

    public function setTaskerServiceId(int $value): static
    {
        $this->taskerServiceId = $value;
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

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function setServiceId(int $value): static
    {
        $this->serviceId = $value;
        return $this;
    }

    public function getAverageRating(): ?int
    {
        return $this->averageRating;
    }

    public function setAverageRating(?int $value): static
    {
        $this->averageRating = $value;
        return $this;
    }

    public function getReviewCount(): ?int
    {
        return $this->reviewCount;
    }

    public function setReviewCount(?int $value): static
    {
        $this->reviewCount = $value;
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
}
