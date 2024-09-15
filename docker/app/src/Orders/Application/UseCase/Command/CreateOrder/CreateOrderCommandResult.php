<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Command\CreateOrder;

class CreateOrderCommandResult
{
    public function __construct(
        public string $id,
    )
    {
    }
}
