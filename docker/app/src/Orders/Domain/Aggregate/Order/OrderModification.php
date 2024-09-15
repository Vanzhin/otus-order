<?php
declare(strict_types=1);


namespace App\Orders\Domain\Aggregate\Order;

use App\Shared\Domain\Service\UlidService;

readonly class OrderModification
{
    private string $id;
    private \DateTimeImmutable $changedAt;
    private OrderStatus $status;

    public function __construct(
        private Order $order,
        OrderStatus   $status = null,
    )
    {
        $this->id = UlidService::generate();
        $this->status = $status ?? OrderStatus::ISSUED;
        $this->changedAt = new \DateTimeImmutable();
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getChangedAt(): \DateTimeImmutable
    {
        return $this->changedAt;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}