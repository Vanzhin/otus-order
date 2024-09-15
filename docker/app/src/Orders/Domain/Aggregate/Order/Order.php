<?php
declare(strict_types=1);

namespace App\Orders\Domain\Aggregate\Order;


use App\Orders\Domain\Aggregate\Order\Specification\OrderSpecification;
use App\Shared\Domain\Service\UlidService;

class Order
{
    private readonly string $id;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $statusUpdatedAt = null;

    public function __construct(
        private readonly string      $userId,
        private readonly OrderStatus $status,
        private readonly float       $sum,
        private readonly OrderSpecification $orderSpecification,

    )
    {
        $this->id = UlidService::generate();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getStatusUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->statusUpdatedAt;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

}