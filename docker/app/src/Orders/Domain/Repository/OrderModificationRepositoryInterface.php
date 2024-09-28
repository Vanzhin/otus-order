<?php
declare(strict_types=1);

namespace App\Orders\Domain\Repository;


use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Aggregate\Order\OrderModification;

interface OrderModificationRepositoryInterface
{
    public function add(OrderModification $orderModification): void;

}