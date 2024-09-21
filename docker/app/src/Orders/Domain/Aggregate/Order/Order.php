<?php
declare(strict_types=1);

namespace App\Orders\Domain\Aggregate\Order;


use App\Orders\Domain\Aggregate\Order\Specification\OrderSpecification;
use App\Orders\Domain\Event\OrderCreatedEvent;
use App\Shared\Domain\Aggregate\Aggregate;
use App\Shared\Domain\Service\UlidService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order extends Aggregate
{
    private readonly string $id;
    private ?\DateTimeImmutable $statusUpdatedAt = null;
    /**
     * @var Collection<OrderModification>
     */
    private Collection $modifications;

    public function __construct(
        private readonly string             $userId,
        private readonly float              $sum,
        private readonly OrderSpecification $orderSpecification,

    )
    {
        $this->id = UlidService::generate();
        $this->modifications = new ArrayCollection();
        $this->modifications->add(new OrderModification($this));
        $this->raise(new OrderCreatedEvent($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getStatusUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->statusUpdatedAt;
    }

    public function getModifications(): Collection
    {
        return $this->modifications;
    }

}