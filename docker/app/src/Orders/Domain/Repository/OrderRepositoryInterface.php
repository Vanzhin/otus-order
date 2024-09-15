<?php
declare(strict_types=1);

namespace App\Orders\Domain\Repository;


use App\Orders\Domain\Aggregate\Order\Order;

interface OrderRepositoryInterface
{
    public function add(Order $order): void;


}