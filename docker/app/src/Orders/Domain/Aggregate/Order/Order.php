<?php
declare(strict_types=1);

namespace App\Orders\Domain\Aggregate\Order;


use App\Orders\Domain\Aggregate\Order\Specification\OrderSpecification;
use App\Shared\Domain\Service\UlidService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order
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