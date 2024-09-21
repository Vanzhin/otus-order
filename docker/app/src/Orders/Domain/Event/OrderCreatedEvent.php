<?php
declare(strict_types=1);


namespace App\Orders\Domain\Event;

use App\Shared\Domain\Event\EventInterface;

class OrderCreatedEvent implements EventInterface
{
    public function __construct(public string $orderId)
    {
    }

}