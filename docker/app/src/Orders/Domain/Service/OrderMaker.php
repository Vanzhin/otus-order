<?php
declare(strict_types=1);


namespace App\Orders\Domain\Service;

use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Factory\OrderFactory;
use App\Orders\Domain\Repository\OrderRepositoryInterface;

class OrderMaker
{
    public function __construct(
        private readonly OrderFactory             $orderFactory,
        private readonly OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function make(string $userId, float $sum): Order
    {
        $order = $this->orderFactory->create($userId, $sum);
        $this->orderRepository->add($order);

        return $order;

    }

}