<?php

declare(strict_types=1);

namespace App\Orders\Application\DTO\Order;

class OrderDTO implements \JsonSerializable
{
    public string $id;
    public string $user_id;
    public float $sum;
    public array $modifications;

    #[\Override] public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
