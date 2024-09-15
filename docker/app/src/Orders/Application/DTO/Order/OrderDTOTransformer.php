<?php

declare(strict_types=1);

namespace App\Orders\Application\DTO\Order;


use App\Orders\Application\DTO\OrderModification\OrderModificationDTOTransformer;
use App\Orders\Domain\Aggregate\Order\Order;
use App\Orders\Domain\Aggregate\Order\OrderModification;

readonly class OrderDTOTransformer
{
    public function __construct(private OrderModificationDTOTransformer $transformer)
    {
    }

    public function fromAccountEntity(Order $order): OrderDTO
    {
        $dto = new OrderDTO();
        $dto->id = $order->getId();
        $dto->user_id = $order->getUserId();
        $dto->sum = $order->getSum();
        $dto->modifications = [];

        /** @var OrderModification $modification */
        foreach ($order->getModifications() as $modification) {
            $dto->modifications[] = $this->transformer->fromAccountEntity($modification);
        }

        return $dto;
    }
}
