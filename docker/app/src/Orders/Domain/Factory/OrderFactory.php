<?php
declare(strict_types=1);


namespace App\Orders\Domain\Factory;

use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Aggregate\Order\Specification\OrderSpecification;

readonly class OrderFactory
{
    public function __construct(
        private OrderSpecification $orderSpecification,
    )
    {
    }

    public function create(
        string $userId,
        float  $sum,
    ): Order
    {
        return new Order($userId, $sum, $this->orderSpecification);
    }

}