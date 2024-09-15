<?php

declare(strict_types=1);

namespace App\Orders\Application\DTO\OrderModification;


use App\Orders\Domain\Aggregate\Order\OrderModification;

class OrderModificationDTOTransformer
{
    public function fromAccountEntity(OrderModification $modification): OrderModificationDTO
    {
        $dto = new OrderModificationDTO();
        $dto->status = $modification->getStatus()->value;
        $dto->changed_at = $modification->getChangedAt()->format(DATE_ATOM);

        return $dto;
    }
}
