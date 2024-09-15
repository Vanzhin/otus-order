<?php
declare(strict_types=1);


namespace App\Orders\Domain\Factory;

use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Aggregate\Order\OrderStatus;
use App\Orders\Domain\Aggregate\Order\Specification\OrderSpecification;

class OrderFactory
{
    public function __construct(
        private readonly OrderSpecification $orderSpecification,
    )
    {
    }

    public function create(
        string $userId,
        float  $sum,
    ): Order
    {
        return new Order($userId, OrderStatus::ISSUED, $sum, $this->orderSpecification);
    }

}