<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Command\CreateOrder;

use App\Shared\Application\Command\Command;

readonly class CreateOrderCommand extends Command
{
    public function __construct(
        public string $userId,
        public float $sum,
    )
    {
    }
}
