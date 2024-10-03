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
 * Entity class for "ReviewsAndRatings" table
 */
#[Entity]
#[Table(name: "ReviewsAndRatings")]
class ReviewsAndRating extends AbstractEntity
{
    #[Id]
    #[Column(name: "ReviewRatingID", type: "integer", unique: true)]
    #[GeneratedValue]
    private int $reviewRatingId;

    #[Column(name: "TaskID", type: "integer")]
    private int $taskId;

    #[Column(name: "Review", type: "string", nullable: true)]
    private ?string $review;

    #[Column(name: "Rating", type: "integer", nullable: true)]
    private ?int $rating;

    #[Column(name: "UserID", type: "integer")]
    private int $userId;

    #[Column(name: "Status", type: "integer", nullable: true)]
    private ?int $status;

    #[Column(name: "CreatedAt", type: "datetime")]
    private DateTime $createdAt;

    #[Column(name: "UpdatedAt", type: "datetime")]
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->status = 1;
    }

    public function getReviewRatingId(): int
    {
        return $this->reviewRatingId;
    }

    public function setReviewRatingId(int $value): static
    {
        $this->reviewRatingId = $value;
        return $this;
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

    public function getReview(): ?string
    {
        return HtmlDecode($this->review);
    }

    public function setReview(?string $value): static
    {
        $this->review = RemoveXss($value);
        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $value): static
    {
        $this->rating = $value;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $value): static
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
